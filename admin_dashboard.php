<?php
session_start();
if (!isset($_SESSION['user'])) { header("Location: login.php"); exit(); }
include 'connectiondb.php';

// Handle adding a new member manually
if (isset($_POST['add_member'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $plan_id = $_POST['plan_id'];
    $conn->query("INSERT INTO members (fname, lname, plan_id) VALUES ('$fname', '$lname', '$plan_id')");
}

// Get Data
$members = $conn->query("SELECT m.member_id, m.fname, m.lname, p.plan_name, p.price 
                         FROM members m INNER JOIN plans p ON m.plan_id = p.plan_id");
?>

<!DOCTYPE html>
<html class="dark">
<head>
    <title>QuickfitZe Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-background text-on-background p-8">

    <div class="max-w-6xl mx-auto">
        <header class="flex justify-between items-center mb-12">
            <div>
                <h1 class="text-3xl font-black text-primary uppercase">QuickfitZe Admin</h1>
                <p class="text-xs font-label-caps text-on-surface-variant">Logged in as: <?php echo $_SESSION['user']; ?></p>
            </div>
            <a href="logout.php" class="border border-outline-variant px-6 py-2 rounded-full text-xs font-bold hover:bg-red-500/20">Logout</a>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <div class="bg-surface-container-high p-8 rounded-3xl border border-primary/10 h-fit">
                <h2 class="text-xl font-bold mb-6 text-primary">Register New Athlete</h2>
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="add_member" value="1">
                    <input type="text" name="fname" placeholder="First Name" required class="w-full bg-background border border-outline-variant p-3 rounded-xl">
                    <input type="text" name="lname" placeholder="Last Name" required class="w-full bg-background border border-outline-variant p-3 rounded-xl">
                    <select name="plan_id" class="w-full bg-background border border-outline-variant p-3 rounded-xl">
                        <option value="1">Basic Plan</option>
                        <option value="2">Pro Plan</option>
                        <option value="3">Elite Plan</option>
                    </select>
                    <button type="submit" class="w-full bg-primary text-background font-black py-3 rounded-xl mt-2">ADD TO ROSTER</button>
                </form>
            </div>

            <div class="lg:col-span-2 bg-surface-container-high p-8 rounded-3xl border border-outline-variant">
                <h2 class="text-xl font-bold mb-6">Registered Members</h2>
                <table class="w-full text-left">
                    <thead class="text-primary text-[10px] font-label-caps border-b border-outline-variant">
                        <tr>
                            <th class="pb-4">Name</th>
                            <th class="pb-4">Membership</th>
                            <th class="pb-4">Fee</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        <?php while($row = $members->fetch_assoc()): ?>
                        <tr class="border-b border-outline-variant/30">
                            <td class="py-4 font-bold"><?php echo $row['fname'] . " " . $row['lname']; ?></td>
                            <td class="py-4"><span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-[10px]"><?php echo $row['plan_name']; ?></span></td>
                            <td class="py-4">$<?php echo $row['price']; ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>