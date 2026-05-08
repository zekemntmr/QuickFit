<?php 
include 'connectiondb.php'; 
// SQL JOIN to get member names and their plan prices
$query = "SELECT members.member_id, members.fname, members.lname, plans.plan_name, plans.price 
          FROM members 
          INNER JOIN plans ON members.plan_id = plans.plan_id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QuickFit | Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;500;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="sidebar">
    <div class="logo">Quick<span>Fit</span></div>
    <nav>
        <a href="#" class="active">Dashboard</a>
        <a href="#">Members</a>
        <a href="#">Plans</a>
        <a href="#">Settings</a>
    </nav>
</div>

<div class="main-content">
    <header>
        <h1>Gym Overview</h1>
        <div class="user-profile">Admin</div>
    </header>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Members</h3>
            <p><?php echo $result->num_rows; ?></p>
        </div>
        <div class="stat-card">
            <h3>Revenue</h3>
            <p>$1,250</p>
        </div>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h2>Active Memberships</h2>
            <button class="btn-add" onclick="openModal()">+ Add Member</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Plan Type</th>
                    <th>Monthly Fee</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>#<?php echo $row['member_id']; ?></td>
                    <td><?php echo $row['fname'] . " " . $row['lname']; ?></td>
                    <td><span class="badge"><?php echo $row['plan_name']; ?></span></td>
                    <td>$<?php echo $row['price']; ?></td>
                    <td>
                        <button class="btn-edit">Edit</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>
<?php
include 'db.php'; // This is your connection file
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // In a real app, you'd check the 'users' table in MySQL
    // SELECT * FROM users WHERE username='$user' AND password='$pass'
    
    if ($user === "admin" && $pass === "elite123") {
        $_SESSION['user'] = $user;
        header("Location: index.php"); 
    } else {
        echo "Invalid Login";
    }
}
?>

<div class="bg-surface-container-low border border-outline-variant rounded-lg overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-surface-container-high text-primary font-label-caps text-xs">
            <tr>
                <th class="p-4 border-b border-outline-variant">ID</th>
                <th class="p-4 border-b border-outline-variant">Full Name</th>
                <th class="p-4 border-b border-outline-variant">Plan Type</th>
                <th class="p-4 border-b border-outline-variant">Monthly Fee</th>
                <th class="p-4 border-b border-outline-variant text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="text-on-surface">
            <?php while($row = $result->fetch_assoc()): ?>
            <tr class="hover:bg-surface-container-high transition-colors">
                <td class="p-4 border-b border-outline-variant">#<?php echo $row['member_id']; ?></td>
                <td class="p-4 border-b border-outline-variant font-bold"><?php echo htmlspecialchars($row['fname'] . " " . $row['lname']); ?></td>
                <td class="p-4 border-b border-outline-variant">
                    <span class="bg-primary-container/30 text-primary text-[10px] px-2 py-1 rounded-full border border-primary/20">
                        <?php echo $row['plan_name']; ?>
                    </span>
                </td>
                <td class="p-4 border-b border-outline-variant">$<?php echo $row['price']; ?></td>
                <td class="p-4 border-b border-outline-variant text-center">
                    <button class="text-primary hover:underline text-sm font-bold">Edit</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>