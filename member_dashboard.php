<?php
session_start();
include 'connectiondb.php';

// 1. SECURITY: Check if member is logged in
if (!isset($_SESSION['member_id'])) {
    header("Location: member_login.php");
    exit();
}

$member_id = $_SESSION['member_id'];
$update_message = "";

// 2. FUNCTIONAL BILLING LOGIC: Handle Plan Change
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_plan'])) {
    $new_plan_id = mysqli_real_escape_string($conn, $_POST['plan_id']);
    $update_sql = "UPDATE members SET plan_id = '$new_plan_id' WHERE member_id = '$member_id'";
    
    if ($conn->query($update_sql)) {
        $update_message = "PLAN UPDATED SUCCESSFULLY";
    }
}

// 3. SQL JOIN: Fetch member profile + current plan
$sql = "SELECT m.*, p.plan_name, p.price, p.plan_id 
        FROM members m 
        INNER JOIN plans p ON m.plan_id = p.plan_id 
        WHERE m.member_id = '$member_id'";

$result = $conn->query($sql);
$athlete = $result->fetch_assoc();

// 4. FETCH ALL PLANS: For the "Manage Billing" options
$all_plans = $conn->query("SELECT * FROM plans");
?>

<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="UTF-8">
    <title>Athlete Console | QuickfitZe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="p-6 md:p-12 bg-[#0f0c14] text-white">

    <div class="max-w-6xl mx-auto">
        <header class="flex justify-between items-center mb-12">
            <div>
                <h1 class="text-4xl font-black text-primary uppercase tracking-tighter">
                    Welcome, <?php echo $athlete['fname']; ?>!
                </h1>
                <p class="text-[10px] text-on-surface-variant uppercase tracking-[0.3em]">Athlete ID: #<?php echo $athlete['member_id']; ?></p>
            </div>
            <a href="logout.php" class="bg-red-500/10 border border-red-500/50 text-red-400 px-6 py-2 rounded-xl text-[10px] font-black hover:bg-red-500 hover:text-white transition-all uppercase tracking-widest">
                Sign Out
            </a>
        </header>

        <?php if($update_message): ?>
            <div class="mb-8 p-4 bg-primary/10 border border-primary text-primary text-[10px] font-black tracking-[0.2em] rounded-xl text-center">
                <?php echo $update_message; ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="bg-[#1a1625] border-2 border-primary p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
                    <span class="text-[10px] font-black text-primary uppercase tracking-[0.2em]">Active Membership</span>
                    <h2 class="text-4xl font-black mt-2 uppercase text-white"><?php echo $athlete['plan_name']; ?></h2>
                    
                    <div class="mt-8 space-y-4">
                        <div class="flex justify-between border-b border-white/5 pb-2">
                            <span class="text-xs text-on-surface-variant">Monthly Rate</span>
                            <span class="text-sm font-bold text-white">₱<?php echo number_format($athlete['price'], 2); ?></span>
                        </div>
                    </div>

                    <form method="POST" class="mt-8 pt-6 border-t border-white/5">
                        <label class="text-[10px] font-black text-on-surface-variant uppercase tracking-widest block mb-4">Manage Billing / Switch Plan</label>
                        <select name="plan_id" class="w-full bg-background border border-outline-variant p-3 rounded-xl text-xs font-bold uppercase mb-4 outline-none focus:border-primary text-white">
                            <?php while($plan = $all_plans->fetch_assoc()): ?>
                                <option value="<?php echo $plan['plan_id']; ?>" <?php echo ($plan['plan_id'] == $athlete['plan_id']) ? 'selected' : ''; ?>>
                                    <?php echo $plan['plan_name']; ?> - ₱<?php echo number_format($plan['price'], 0); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                        <button type="submit" name="change_plan" class="w-full bg-primary text-background font-black py-4 rounded-2xl text-[10px] uppercase tracking-widest hover:opacity-90 transition-all">
                            Update Subscription
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2 bg-[#1a1625] p-8 rounded-[2.5rem] border border-white/5 shadow-2xl">
                <div class="mb-8">
                    <h2 class="text-xl font-bold uppercase tracking-tight text-white">Performance Tracking</h2>
                    <p class="text-xs text-on-surface-variant italic underline">Showing real-time data for <?php echo $athlete['plan_name']; ?> Tier</p>
                </div>
                <canvas id="memberChart" class="max-h-[300px]"></canvas>
            </div>

        </div>
    </div>

    <script>
        const ctx = document.getElementById('memberChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [{
                    label: 'Activity Score',
                    data: [40, 65, 55, 90],
                    borderColor: '#d5baff',
                    backgroundColor: 'rgba(213, 186, 255, 0.1)',
                    borderWidth: 4,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    y: { display: false },
                    x: { ticks: { color: '#969299' }, grid: { display: false } }
                }
            }
        });
    </script>
</body>
</html>