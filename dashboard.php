<?php
session_start();
/* 1. SECURITY: Check if the user is logged in. If not, kick them back to login.php */
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit(); }

/* 2. DATABASE: Connect to your MySQL database using the connection file */
include 'connectiondb.php';

/* NEW: CONFIRMATION LOGIC */
if (isset($_GET['confirm_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['confirm_id']);
    $conn->query("UPDATE members SET status = 'Active', created_at = NOW() WHERE member_id = $id");
    header("Location: dashboard.php");
    exit();
}

/* 3. DELETE LOGIC (The "D" in CRUD) */
if (isset($_GET['delete_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    $conn->query("DELETE FROM members WHERE member_id = $id");
    header("Location: dashboard.php");
    exit();
}

/* 4. CREATE & UPDATE LOGIC (The "C" & "U" in CRUD) */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $plan_id = $_POST['plan_id'];

    if (isset($_POST['member_id']) && !empty($_POST['member_id'])) {
        $id = $_POST['member_id'];
        $conn->query("UPDATE members SET fname='$fname', lname='$lname', plan_id='$plan_id' WHERE member_id=$id");
    } else {
        // New members are inserted as 'Pending' by default
        $conn->query("INSERT INTO members (fname, lname, plan_id, status) VALUES ('$fname', '$lname', '$plan_id', 'Pending')");
    }
    header("Location: dashboard.php");
    exit();
}

/* 5. SEARCH & READ LOGIC (The "R" in CRUD) */
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'member_id';

// Pull Active Members for the main roster - ADDED m.created_at
$query = "SELECT m.member_id, m.fname, m.lname, m.plan_id, m.status, m.created_at, p.plan_name, p.price 
          FROM members m 
          INNER JOIN plans p ON m.plan_id = p.plan_id 
          WHERE (m.fname LIKE '%$search%' OR m.lname LIKE '%$search%' OR p.plan_name LIKE '%$search%')
          AND m.status = 'Active'
          ORDER BY $sort DESC";
$members_result = $conn->query($query);

// Pull Pending Members for the confirmation section
$pending_query = "SELECT m.member_id, m.fname, m.lname, p.plan_name 
                  FROM members m 
                  INNER JOIN plans p ON m.plan_id = p.plan_id 
                  WHERE m.status = 'Pending'";
$pending_result = $conn->query($pending_query);

/* 6. CHART DATA (Only counts active members to match the table) */
$chart_data = $conn->query("SELECT p.plan_name, COUNT(m.member_id) as count FROM plans p LEFT JOIN members m ON p.plan_id = m.plan_id AND m.status = 'Active' GROUP BY p.plan_id");
$labels = []; $counts = [];
while($row = $chart_data->fetch_assoc()){
    $labels[] = $row['plan_name'];
    $counts[] = $row['count'];
}
?>

<!DOCTYPE html>
<html class="dark">
<head>
    <title>QuickfitZe | Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="style.css?v=1.1">  
    <style>
        input[type="text"], select { color: black !important; background-color: white !important; }
    </style>
</head>
<body class="bg-background text-on-background p-6">

    <div class="max-w-7xl mx-auto">
        <header class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
            <div>
                <h1 class="text-4xl font-black text-primary uppercase tracking-tighter">QuickfitZe Console</h1>
                <p class="text-xs font-label-caps text-on-surface-variant">Admin: <?php echo $_SESSION['user']; ?></p>
            </div>
            <div class="flex gap-4 w-full md:w-auto">
                <form method="GET" class="relative flex-grow">
                    <input type="text" name="search" value="<?php echo $search; ?>" placeholder="Search athletes..." 
                           class="w-full bg-surface-container-high border border-outline-variant px-4 py-2 rounded-xl focus:border-primary outline-none text-sm">
                    <button type="submit" class="absolute right-3 top-2 text-primary">🔍</button>
                </form>
                <a href="logout.php" class="bg-surface-container-high border border-red-500/30 text-red-400 px-6 py-2 rounded-xl text-xs font-bold hover:bg-red-500/10 transition-all">Logout</a>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-surface-container-high p-6 rounded-3xl border border-primary/20 shadow-xl">
                    <h2 id="form-title" class="text-sm font-label-caps text-primary mb-4">Add New Member</h2>
                    <form id="member-form" method="POST" class="space-y-3">
                        <input type="hidden" name="member_id" id="edit-id" value="">
                        <input type="text" name="fname" placeholder="First Name" required class="w-full bg-background border border-outline-variant p-3 rounded-xl text-sm">
                        <input type="text" name="lname" placeholder="Last Name" required class="w-full bg-background border border-outline-variant p-3 rounded-xl text-sm">
                        <select name="plan_id" class="w-full bg-background border border-outline-variant p-3 rounded-xl text-sm">
                            <option value="1">Basic Plan</option>
                            <option value="2">Premium Plan</option>
                            <option value="3">Elite Plan</option>
                        </select>
                        <button type="submit" id="submit-btn" class="w-full bg-primary text-background font-black py-3 rounded-xl hover:opacity-90 transition-all text-xs uppercase tracking-widest">Register</button>
                        <button type="button" id="cancel-btn" onclick="window.location.reload()" class="hidden w-full text-white/30 text-[10px] uppercase mt-2">Cancel Edit</button>
                    </form>
                </div>

                <div class="bg-surface-container-high p-6 rounded-3xl border border-outline-variant">
                    <h2 class="text-sm font-label-caps text-on-surface-variant mb-4">Membership Distribution</h2>
                    <canvas id="membershipChart"></canvas>
                </div>
            </div>

            <div class="lg:col-span-3 space-y-8">
                
                <?php if($pending_result->num_rows > 0): ?>
                <div class="bg-primary/5 p-8 rounded-3xl border border-primary/30 shadow-2xl">
                    <h2 class="text-xl font-bold text-primary mb-4 uppercase italic">Pending Approvals</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php while($p_row = $pending_result->fetch_assoc()): ?>
                        <div class="bg-background p-4 rounded-2xl flex justify-between items-center border border-primary/20">
                            <div>
                                <p class="text-sm font-bold"><?php echo $p_row['fname'] . " " . $p_row['lname']; ?></p>
                                <p class="text-[10px] text-primary uppercase font-bold"><?php echo $p_row['plan_name']; ?></p>
                            </div>
                            <a href="dashboard.php?confirm_id=<?php echo $p_row['member_id']; ?>" 
                               class="bg-primary text-background px-4 py-2 rounded-lg text-[10px] font-black uppercase hover:scale-105 transition-all">Confirm</a>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php endif; ?>

                <div class="bg-surface-container-high p-8 rounded-3xl border border-outline-variant shadow-2xl overflow-x-auto">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold">Active Members Roster</h2>
                        <div class="text-[10px] font-label-caps text-on-surface-variant">
                            Sorted by: <span class="text-primary"><?php echo $sort; ?></span>
                        </div>
                    </div>
                    
                    <table class="w-full text-left">
                        <thead class="text-primary text-[10px] font-label-caps border-b border-outline-variant">
                            <tr>
                                <th class="pb-4">ID</th>
                                <th class="pb-4">Full Name</th>
                                <th class="pb-4">Membership Tier</th>
                                <th class="pb-4">Monthly Rate</th>
                                <th class="pb-4">Renewal Date</th> <th class="pb-4">Status</th>
                                <th class="pb-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-outline-variant/20">
                            <?php if($members_result->num_rows > 0): ?>
                                <?php while($row = $members_result->fetch_assoc()): 
                                    // Calculate Renewal Date
                                    $reg_date = strtotime($row['created_at']);
                                    $renew_date = strtotime("+30 days", $reg_date);
                                    $is_expired = (time() > $renew_date);
                                ?>
                                <tr class="hover:bg-primary/5 transition-colors">
                                    <td class="py-4 text-on-surface-variant">#<?php echo $row['member_id']; ?></td>
                                    <td class="py-4 font-bold text-on-surface"><?php echo $row['fname'] . " " . $row['lname']; ?></td>
                                    <td class="py-4">
                                        <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-[10px] font-bold border border-primary/20 uppercase">
                                            <?php echo $row['plan_name']; ?>
                                        </span>
                                    </td>
                                    <td class="py-4 text-on-surface">₱<?php echo number_format($row['price'], 2); ?></td>
                                    
                                    <td class="py-4">
                                        <span class="<?php echo $is_expired ? 'text-red-500 font-black' : 'text-on-surface'; ?> text-xs">
                                            <?php echo date('M d, Y', $renew_date); ?>
                                        </span>
                                        <?php if($is_expired): ?>
                                            <span class="block text-[8px] text-red-500 uppercase font-bold tracking-tighter">Needs Renewal</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="py-4"><span class="<?php echo $is_expired ? 'text-red-500' : 'text-green-400'; ?> text-[10px] font-bold tracking-widest">● <?php echo $is_expired ? 'EXPIRED' : strtoupper($row['status']); ?></span></td>
                                    <td class="py-4 text-right space-x-3">
                                        <button type="button" onclick="editMember('<?php echo $row['member_id']; ?>', '<?php echo $row['fname']; ?>', '<?php echo $row['lname']; ?>', '<?php echo $row['plan_id']; ?>')" 
                                                class="text-blue-400 text-[10px] uppercase font-black hover:underline transition-all">Edit</button>
                                        <a href="dashboard.php?delete_id=<?php echo $row['member_id']; ?>" 
                                           onclick="return confirm('Delete Member?')" 
                                           class="text-red-400 text-[10px] uppercase font-black hover:underline transition-all">Delete</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="7" class="py-10 text-center text-on-surface-variant italic">No active members found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function editMember(id, fname, lname, plan) {
            document.getElementById('edit-id').value = id;
            document.getElementsByName('fname')[0].value = fname;
            document.getElementsByName('lname')[0].value = lname;
            document.getElementsByName('plan_id')[0].value = plan;
            document.getElementById('form-title').innerText = "Update Athlete";
            document.getElementById('submit-btn').innerText = "Save Changes";
            document.getElementById('cancel-btn').classList.remove('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        const ctx = document.getElementById('membershipChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    data: <?php echo json_encode($counts); ?>,
                    backgroundColor: ['#3b1a6b', '#632bb3', '#d5baff'],
                    borderColor: '#1a181e',
                    borderWidth: 2
                }]
            },
            options: {
                plugins: {
                    legend: { labels: { color: '#969299', font: { size: 10 } } }
                }
            }
        });
    </script>
</body>
</html>