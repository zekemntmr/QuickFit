<?php
session_start();
include 'connectiondb.php';
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    /* SQL JOIN: Connects the login account to the actual member details */
    $sql = "SELECT ma.*, m.fname, m.lname 
            FROM member_accounts ma 
            INNER JOIN members m ON ma.member_id = m.member_id 
            WHERE ma.username = '$username'";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['member_user'] = $user['fname'] . " " . $user['lname'];
            $_SESSION['member_id'] = $user['member_id'];
            header("Location: member_dashboard.php");
            exit();
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

    <div class="max-w-md w-full bg-surface border border-outline-variant p-10 rounded-[2.5rem] shadow-2xl">
        
        <div class="text-center mb-10">
            <h1 class="text-5xl font-black text-primary uppercase tracking-tighter">QuickfitZe</h1>
            <p class="text-[10px] text-on-surface-variant uppercase tracking-[0.4em] mt-2">Athlete Portal Login</p>
        </div>

        <?php if($error): ?>
            <p class="text-red-400 text-[10px] font-bold text-center mb-6 tracking-widest italic uppercase">! <?php echo $error; ?> !</p>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label class="text-[10px] uppercase text-primary font-bold mb-2 block ml-1 tracking-widest">Username</label>
                <input type="text" name="username" required 
                       class="w-full p-4 rounded-2xl text-sm font-bold outline-none border-2 border-transparent focus:border-primary transition-all">
            </div>

            <div>
                <label class="text-[10px] uppercase text-primary font-bold mb-2 block ml-1 tracking-widest">Password</label>
                <input type="password" name="password" required 
                       class="w-full p-4 rounded-2xl text-sm font-bold outline-none border-2 border-transparent focus:border-primary transition-all">
            </div>
            
            <div class="pt-4">
                <button type="submit" class="w-full bg-transparent text-white font-black py-4 rounded-2xl border-none transition-all text-xs uppercase tracking-widest hover:scale-105 active:scale-95">
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