<?php
session_start();
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit(); }
include 'connectiondb.php';

// --- HANDLE DATA INSERTION ---
if (isset($_POST['add_member'])) {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $plan_id = $_POST['plan_id'];
    $conn->query("INSERT INTO members (fname, lname, plan_id) VALUES ('$fname', '$lname', '$plan_id')");
}

// --- HANDLE SEARCH & SORT ---
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'member_id';

// --- SQL JOIN QUERY ---
$query = "SELECT m.member_id, m.fname, m.lname, p.plan_name, p.price 
          FROM members m 
          INNER JOIN plans p ON m.plan_id = p.plan_id 
          WHERE m.fname LIKE '%$search%' OR m.lname LIKE '%$search%' OR p.plan_name LIKE '%$search%'
          ORDER BY $sort DESC";
$members_result = $conn->query($query);

// --- DATA FOR CHART.JS (Count members per plan) ---
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
    <link rel="stylesheet" href="style.css">
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
                <a href="logout.php" class="bg-surface-container-high border border-red-500/30 text-red-400 px-6 py-2 rounded-xl text-xs font-bold hover:bg-red-500/10">Logout</a>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-surface-container-high p-6 rounded-3xl border border-primary/20 shadow-xl">
                    <h2 class="text-sm font-label-caps text-primary mb-4">Add New Athlete</h2>
                    <form method="POST" class="space-y-3">
                        <input type="hidden" name="add_member" value="1">
                        <input type="text" name="fname" placeholder="First Name" required class="w-full bg-background border border-outline-variant p-3 rounded-xl text-sm">
                        <input type="text" name="lname" placeholder="Last Name" required class="w-full bg-background border border-outline-variant p-3 rounded-xl text-sm">
                        <select name="plan_id" class="w-full bg-background border border-outline-variant p-3 rounded-xl text-sm">
                            <option value="1">Basic Plan</option>
                            <option value="2">Pro Plan</option>
                            <option value="3">Elite Plan</option>
                        </select>
                        <button type="submit" class="w-full bg-primary text-background font-black py-3 rounded-xl hover:opacity-90 transition-all text-xs uppercase tracking-widest">Register</button>
                    </form>
                </div>

                <div class="bg-surface-container-high p-6 rounded-3xl border border-outline-variant">
                    <h2 class="text-sm font-label-caps text-on-surface-variant mb-4">Membership Distribution</h2>
                    <canvas id="membershipChart"></canvas>
                </div>
            </div>

            <div class="lg:col-span-3 bg-surface-container-high p-8 rounded-3xl border border-outline-variant shadow-2xl overflow-x-auto">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">Athlete Roster</h2>
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
                            <th class="pb-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-outline-variant/20">
                        <?php if($members_result->num_rows > 0): ?>
                            <?php while($row = $members_result->fetch_assoc()): ?>
                            <tr class="hover:bg-primary/5 transition-colors">
                                <td class="py-4 text-on-surface-variant">#<?php echo $row['member_id']; ?></td>
                                <td class="py-4 font-bold text-on-surface"><?php echo $row['fname'] . " " . $row['lname']; ?></td>
                                <td class="py-4">
                                    <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-[10px] font-bold border border-primary/20 uppercase">
                                        <?php echo $row['plan_name']; ?>
                                    </span>
                                </td>
                                <td class="py-4 text-on-surface">$<?php echo number_format($row['price'], 2); ?></td>
                                <td class="py-4"><span class="text-green-400 text-[10px] font-bold tracking-widest">● ACTIVE</span></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="py-10 text-center text-on-surface-variant italic">No athletes found matching your search.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
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
                    legend: { labels: { color: '#968d9e', font: { size: 10 } } }
                }
            }
        });
    </script>
</body>
</html>