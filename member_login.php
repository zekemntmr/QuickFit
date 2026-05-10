<?php
session_start();
include 'connectiondb.php';
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    /* SQL JOIN: Now includes 'm.status' to verify admin confirmation */
    $sql = "SELECT ma.*, m.fname, m.lname, m.status 
            FROM member_accounts ma 
            INNER JOIN members m ON ma.member_id = m.member_id 
            WHERE ma.username = '$username'";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // 1. First, verify the password
        if (password_verify($password, $user['password'])) {
            
            // 2. NEW CHECK: Check if the Admin has confirmed the account
            if ($user['status'] == 'Pending') {
                $error = "ACCOUNT PENDING ADMIN APPROVAL";
            } else if ($user['status'] == 'Active') {
                // Login successful only if Active
                $_SESSION['member_user'] = $user['fname'] . " " . $user['lname'];
                $_SESSION['member_id'] = $user['member_id'];
                header("Location: member_dashboard.php");
                exit();
            } else {
                $error = "ACCOUNT IS INACTIVE";
            }

        } else {
            $error = "INVALID PASSWORD";
        }
    } else {
        $error = "ATHLETE NOT FOUND";
    }
}
?>

<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="UTF-8">
    <title>QuickfitZe | Athlete Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body class="min-h-screen flex items-center justify-center p-6 bg-[#0f0c14]">
    <nav class="fixed top-0 z-50 flex justify-between items-center w-full px-margin py-4 border-b border-outline-variant bg-surface-container-low/90 backdrop-blur-md">
        <a href="index.php" class="text-2xl font-black tracking-tighter text-primary uppercase">QuickfitZe</a>
        
        <div class="hidden md:flex gap-8 items-center">
            <a class="text-on-surface-variant text-[10px] font-bold uppercase tracking-widest hover:text-primary transition-all" href="index.php#memberships">Memberships</a>
            <a class="text-primary border-b-2 border-primary pb-1 text-[10px] font-bold uppercase tracking-widest" href="trainers.php">Trainers</a>
        </div>

        <div class="flex items-center gap-4">
            <div class="hidden lg:flex items-center bg-surface-container-high px-4 py-2 border-b border-outline focus-within:border-primary transition-all">
                <span class="material-symbols-outlined text-outline text-[20px]">search</span>
                <input class="bg-transparent border-none focus:ring-0 text-[10px] font-bold uppercase tracking-widest placeholder:text-outline text-on-surface" placeholder="SEARCH TRAINERS" type="text"/>
            </div>
            <button onclick="window.location.href='member_login.php'" class="text-xs font-bold px-4 py-2 text-on-surface-variant hover:text-primary transition-all uppercase tracking-widest">Login</button>
            <button onclick="window.location.href='member_register.php'" class="bg-primary text-background text-xs font-bold px-6 py-3 hover:opacity-90 transition-all uppercase tracking-widest">Join Now</button>
        </div>
    </nav>

    <div class="max-w-md w-full bg-surface border border-outline-variant p-10 rounded-[2.5rem] shadow-2xl">
        
        <div class="text-center mb-10">
            <h1 class="text-5xl font-black text-primary uppercase tracking-tighter">QuickfitZe</h1>
            <p class="text-[10px] text-on-surface-variant uppercase tracking-[0.4em] mt-2">Athlete Portal Login</p>
        </div>

        <?php if($error): ?>
            <div class="bg-red-500/10 border border-red-500/50 p-4 rounded-xl mb-6">
                <p class="text-red-400 text-[10px] font-bold text-center tracking-widest italic uppercase">! <?php echo $error; ?> !</p>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label class="text-[10px] uppercase text-primary font-bold mb-2 block ml-1 tracking-widest">Username</label>
                <input type="text" name="username" required 
                       class="w-full p-4 rounded-2xl text-sm font-bold outline-none border-2 border-transparent focus:border-primary transition-all text-black bg-white">
            </div>

            <div>
                <label class="text-[10px] uppercase text-primary font-bold mb-2 block ml-1 tracking-widest">Password</label>
                <input type="password" name="password" required 
                       class="w-full p-4 rounded-2xl text-sm font-bold outline-none border-2 border-transparent focus:border-primary transition-all text-black bg-white">
            </div>
            
            <div class="pt-4">
                <button type="submit" class="w-full bg-primary text-background font-black py-4 rounded-2xl transition-all text-xs uppercase tracking-widest hover:scale-105 active:scale-95 shadow-lg shadow-primary/20">
                    Log In Account
                </button>
            </div>
        </form>

        <div class="mt-10 pt-6 border-t border-outline-variant text-center">
            <p class="text-[10px] text-on-surface-variant uppercase tracking-widest">
                Don't have an account? 
                <a href="member_register.php" class="text-primary font-bold hover:underline">Register</a>
            </p>
        </div>
    </div>

</body>
</html>