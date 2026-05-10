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

// 2. FUNCTIONAL BILLING LOGIC: Handle Plan Change & Renewal
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_plan'])) {
    $new_plan_id = mysqli_real_escape_string($conn, $_POST['plan_id']);
    // Resetting created_at to NOW() ensures the 30-day timer restarts on renewal/update
    $update_sql = "UPDATE members SET plan_id = '$new_plan_id', created_at = NOW() WHERE member_id = '$member_id'";
    
    if ($conn->query($update_sql)) {
        $update_message = "PLAN UPDATED & RENEWED SUCCESSFULLY";
    }
}

// 3. SQL JOIN: Fetch member profile + current plan
$sql = "SELECT m.*, p.plan_name, p.price, p.plan_id, m.created_at 
        FROM members m 
        INNER JOIN plans p ON m.plan_id = p.plan_id 
        WHERE m.member_id = '$member_id'";

$result = $conn->query($sql);
$athlete = $result->fetch_assoc();

// 4. EXPIRATION & CALENDAR LOGIC
$registration_date = strtotime($athlete['created_at']);
$expiration_date = strtotime("+30 days", $registration_date);
$is_expired = (time() > $expiration_date);

// Calendar Vars
$exp_day = date('j', $expiration_date);
$exp_month = date('n', $expiration_date);
$exp_year = date('Y', $expiration_date);
$days_in_month = cal_days_in_month(CAL_GREGORIAN, $exp_month, $exp_year);
$first_day_of_month = date('w', mktime(0, 0, 0, $exp_month, 1, $exp_year));

// 5. FETCH ALL PLANS
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
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeInUp 0.6s ease-out forwards; }
        .delay-1 { animation-delay: 0.2s; opacity: 0; }
        .delay-2 { animation-delay: 0.4s; opacity: 0; }
    </style>
</head>
<body class="p-6 md:p-12 bg-[#0f0c14] text-white">

    <?php if($is_expired): ?>
    <div class="fixed top-5 left-1/2 -translate-x-1/2 z-[100] w-full max-w-md px-4">
        <div class="bg-red-600 text-white p-4 rounded-2xl shadow-2xl flex items-center gap-4 border-2 border-red-400 animate-bounce">
            <span class="text-xl">⚠️</span>
            <p class="text-[10px] font-black uppercase tracking-widest">Membership Expired - Please Renew Below</p>
        </div>
    </div>
    <?php endif; ?>

    <div class="max-w-6xl mx-auto">
        <header class="flex justify-between items-center mb-12 animate-fade-in">
            <div>
                <h1 class="text-4xl font-black text-primary uppercase tracking-tighter">
                    Welcome, <?php echo $athlete['fname']; ?>!
                </h1>
                <p class="text-[10px] text-on-surface-variant uppercase tracking-[0.3em]">
                    Status: <span class="<?php echo $is_expired ? 'text-red-500' : 'text-green-500'; ?> font-bold"><?php echo $is_expired ? 'EXPIRED' : 'ACTIVE'; ?></span>
                </p>
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
            
            <div class="lg:col-span-1 space-y-8 animate-fade-in delay-1">
                
                <div class="bg-[#1a1625] border-2 <?php echo $is_expired ? 'border-red-500' : 'border-primary'; ?> p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden transition-colors duration-500">
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
                            <?php $all_plans->data_seek(0); // Reset pointer ?>
                            <?php while($plan = $all_plans->fetch_assoc()): ?>
                                <option value="<?php echo $plan['plan_id']; ?>" <?php echo ($plan['plan_id'] == $athlete['plan_id']) ? 'selected' : ''; ?>>
                                    <?php echo $plan['plan_name']; ?> - ₱<?php echo number_format($plan['price'], 0); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                        <button type="submit" name="change_plan" class="w-full <?php echo $is_expired ? 'bg-red-600' : 'bg-primary'; ?> text-background font-black py-4 rounded-2xl text-[10px] uppercase tracking-widest hover:opacity-90 transition-all">
                            <?php echo $is_expired ? 'Renew Access' : 'Update Subscription'; ?>
                        </button>
                    </form>
                </div>

                <div class="bg-[#1a1625] p-6 rounded-[2.5rem] border border-white/5 shadow-2xl">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-[10px] font-black uppercase text-primary tracking-widest">Renewal Schedule</h2>
                        <p class="text-[10px] text-on-surface-variant font-bold"><?php echo date('F Y', $expiration_date); ?></p>
                    </div>
                    <div class="grid grid-cols-7 gap-1 text-center">
                        <?php foreach(['S','M','T','W','T','F','S'] as $day_head): ?>
                            <div class="text-[8px] font-black text-white/20 py-1"><?php echo $day_head; ?></div>
                        <?php endforeach; ?>

                        <?php for($i = 0; $i < $first_day_of_month; $i++) echo '<div></div>'; ?>

                        <?php for($d = 1; $d <= $days_in_month; $d++): 
                            $is_expiry_day = ($d == $exp_day); 
                        ?>
                            <div class="relative p-1 text-[10px] font-bold rounded-md transition-all
                                <?php if($is_expiry_day): ?>
                                    bg-primary text-background scale-125 shadow-lg shadow-primary/40 z-10
                                <?php else: ?>
                                    text-on-surface-variant
                                <?php endif; ?>">
                                
                                <?php echo $d; ?>

                                <?php if($is_expiry_day): ?>
                                    <span class="absolute -top-1 -right-1 flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 bg-[#1a1625] p-8 rounded-[2.5rem] border border-white/5 shadow-2xl animate-fade-in delay-1">
                <div class="mb-8 flex justify-between items-start">
                    <div>
                        <h2 class="text-xl font-bold uppercase tracking-tight text-white">Performance Tracking</h2>
                        <p class="text-xs text-on-surface-variant italic underline">Showing real-time data for <?php echo $athlete['plan_name']; ?> Tier</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[8px] text-on-surface-variant uppercase tracking-widest">Renewal Date</p>
                        <p class="text-xs font-black text-primary"><?php echo date('M d, Y', $expiration_date); ?></p>
                    </div>
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
                    data: [<?php echo $is_expired ? '0,0,0,0' : '40, 65, 55, 90'; ?>],
                    borderColor: '<?php echo $is_expired ? '#ef4444' : '#d5baff'; ?>',
                    backgroundColor: 'rgba(213, 186, 255, 0.1)',
                    borderWidth: 4,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    y: { display: false, min: 0, max: 100 },
                    x: { ticks: { color: '#969299' }, grid: { display: false } }
                }
            }
        });
    </script>
</body>
</html>