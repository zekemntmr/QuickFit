<?php
session_start();
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit(); }
include 'connectiondb.php';

// --- 1. HANDLE DELETE (The "D" in CRUD) ---
if (isset($_GET['delete_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    $conn->query("DELETE FROM members WHERE member_id = $id");
    header("Location: dashboard.php"); // Refresh
    exit();
}

// --- 2. HANDLE INSERT & UPDATE (The "C" & "U" in CRUD) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $plan_id = $_POST['plan_id'];

    if (isset($_POST['member_id']) && !empty($_POST['member_id'])) {
        // UPDATE existing member
        $id = $_POST['member_id'];
        $conn->query("UPDATE members SET fname='$fname', lname='$lname', plan_id='$plan_id' WHERE member_id=$id");
    } else {
        // INSERT new member
        $conn->query("INSERT INTO members (fname, lname, plan_id) VALUES ('$fname', '$lname', '$plan_id')");
    }
    header("Location: dashboard.php");
    exit();
}

// --- 3. HANDLE SEARCH & READ (The "R" in CRUD) ---
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'member_id';

$query = "SELECT m.member_id, m.fname, m.lname, m.plan_id, p.plan_name, p.price 
          FROM members m 
          INNER JOIN plans p ON m.plan_id = p.plan_id 
          WHERE m.fname LIKE '%$search%' OR m.lname LIKE '%$search%' OR p.plan_name LIKE '%$search%'
          ORDER BY $sort DESC";
$members_result = $conn->query($query);

// --- 4. DATA FOR CHART.JS ---
$chart_data = $conn->query("SELECT p.plan_name, COUNT(m.member_id) as count FROM plans p LEFT JOIN members m ON p.plan_id = m.plan_id GROUP BY p.plan_id");
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
    <link rel="stylesheet" href="style.css?v=1.2">
    <style>
        /* This ensures you can SEE the text while typing */
        input[type="text"], select {
            color: black !important;
            background-color: white !important;
        }
        /* Custom Purple Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-thumb { background: #632bb3; border-radius: 10px; }
    </style>
</head>
<body class="bg-[#1a1625] text-[#f1eff3] p-6">

    <div class="max-w-7xl mx-auto">
        <header class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
            <div>
                <h1 class="text-4xl font-black text-[#d5baff] uppercase tracking-tighter">QuickfitZe Console</h1>
                <p class="text-xs opacity-60">Admin: <?php echo $_SESSION['user']; ?></p>
            </div>
            <div class="flex gap-4 w-full md:w-auto">
                <form method="GET" class="relative flex-grow">
                    <input type="text" name="search" value="<?php echo $search; ?>" placeholder="Search athletes..." 
                           class="w-full bg-white border border-purple-900/30 px-4 py-2 rounded-xl focus:ring-2 ring-[#d5baff] outline-none text-sm text-black">
                    <button type="submit" class="absolute right-3 top-2 text-purple-900">🔍</button>
                </form>
                <a href="logout.php" class="bg-red-500/10 border border-red-500/30 text-red-400 px-6 py-2 rounded-xl text-xs font-bold hover:bg-red-500/20 transition-all">Logout</a>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-[#241f31] p-6 rounded-3xl border border-white/5 shadow-xl">
                    <h2 id="form-title" class="text-sm font-bold text-[#d5baff] uppercase mb-4 tracking-widest">Register Athlete</h2>
                    <form id="member-form" method="POST" class="space-y-3">
                        <input type="hidden" name="member_id" id="edit-id" value="">
                        
                        <label class="text-[10px] uppercase opacity-50 ml-1">First Name</label>
                        <input type="text" name="fname" id="edit-fname" required class="w-full p-3 rounded-xl text-sm">
                        
                        <label class="text-[10px] uppercase opacity-50 ml-1">Last Name</label>
                        <input type="text" name="lname" id="edit-lname" required class="w-full p-3 rounded-xl text-sm">
                        
                        <label class="text-[10px] uppercase opacity-50 ml-1">Tier</label>
                        <select name="plan_id" id="edit-plan" class="w-full p-3 rounded-xl text-sm">
                            <option value="1">Basic Plan</option>
                            <option value="2">Premium Plan</option>
                            <option value="3">Elite Plan</option>
                        </select>
                        
                        <button type="submit" id="submit-btn" class="w-full bg-[#d5baff] text-[#1a1625] font-black py-4 rounded-xl hover:scale-[1.02] active:scale-95 transition-all text-xs uppercase tracking-widest mt-2">
                            Add to Roster
                        </button>
                        <button type="button" id="cancel-btn" onclick="resetForm()" class="hidden w-full border border-white/10 text-xs py-2 rounded-xl opacity-50 hover:opacity-100">Cancel Edit</button>
                    </form>
                </div>

                <div class="bg-[#241f31] p-6 rounded-3xl border border-white/5 shadow-xl">
                    <h2 class="text-sm font-bold text-white/40 mb-4 uppercase tracking-widest text-center">Plan Stats</h2>
                    <canvas id="membershipChart"></canvas>
                </div>
            </div>

            <div class="lg:col-span-3 bg-[#241f31] p-8 rounded-3xl border border-white/5 shadow-2xl overflow-x-auto">
                <h2 class="text-xl font-bold mb-6">Members Roster</h2>
                
                <table class="w-full text-left">
                    <thead class="text-[#d5baff] text-[10px] uppercase border-b border-white/10">
                        <tr>
                            <th class="pb-4">Athlete</th>
                            <th class="pb-4">Membership</th>
                            <th class="pb-4">Rate</th>
                            <th class="pb-4 text-right">Management</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-white/5">
                        <?php if($members_result->num_rows > 0): ?>
                            <?php while($row = $members_result->fetch_assoc()): ?>
                            <tr class="hover:bg-white/[0.02] transition-colors group">
                                <td class="py-4 font-bold"><?php echo $row['fname'] . " " . $row['lname']; ?></td>
                                <td class="py-4 text-[#d5baff] text-xs font-black uppercase"><?php echo $row['plan_name']; ?></td>
                                <td class="py-4 opacity-70">$<?php echo number_format($row['price'], 2); ?></td>
                                <td class="py-4 text-right space-x-3">
                                    <button onclick="editMember('<?php echo $row['member_id']; ?>', '<?php echo $row['fname']; ?>', '<?php echo $row['lname']; ?>', '<?php echo $row['plan_id']; ?>')" 
                                            class="text-blue-400 text-xs hover:underline uppercase font-bold tracking-tighter">Edit</button>
                                    <a href="dashboard.php?delete_id=<?php echo $row['member_id']; ?>" 
                                       onclick="return confirm('Remove this member?')" 
                                       class="text-red-400 text-xs hover:underline uppercase font-bold tracking-tighter">Delete</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="py-10 text-center opacity-30 italic">No athletes found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // --- Edit Mode Logic ---
        function editMember(id, fname, lname, plan) {
            document.getElementById('form-title').innerText = "Update Athlete";
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-fname').value = fname;
            document.getElementById('edit-lname').value = lname;
            document.getElementById('edit-plan').value = plan;
            document.getElementById('submit-btn').innerText = "Update Member";
            document.getElementById('submit-btn').style.backgroundColor = "#93c5fd"; // Blue for update
            document.getElementById('cancel-btn').classList.remove('hidden');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function resetForm() {
            document.getElementById('form-title').innerText = "Register Athlete";
            document.getElementById('edit-id').value = "";
            document.getElementById('member-form').reset();
            document.getElementById('submit-btn').innerText = "Add to Roster";
            document.getElementById('submit-btn').style.backgroundColor = "#d5baff";
            document.getElementById('cancel-btn').classList.add('hidden');
        }

        // --- Chart.js Configuration ---
        const ctx = document.getElementById('membershipChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    data: <?php echo json_encode($counts); ?>,
                    backgroundColor: ['#3b1a6b', '#632bb3', '#d5baff'],
                    borderColor: '#241f31',
                    borderWidth: 4
                }]
            },
            options: {
                cutout: '70%',
                plugins: {
                    legend: { position: 'bottom', labels: { color: '#ffffff50', font: { size: 10 } } }
                }
            }
        });
    </script>
</body>
</html>