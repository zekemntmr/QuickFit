<?php
session_start();
include 'connectiondb.php';
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // JOIN query to get both account and profile info
    $sql = "SELECT ma.*, m.fname FROM member_accounts ma 
            JOIN members m ON ma.member_id = m.member_id 
            WHERE ma.username = '$username'";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['member'] = $user['fname'];
            $_SESSION['member_id'] = $user['member_id'];
            header("Location: member_home.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No athlete found with that username.";
    }
}
?>

<!DOCTYPE html>
<html class="dark">
<head>
    <title>QuickfitZe | Athlete Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0f0c14] text-white flex items-center justify-center min-h-screen p-6">
    <div class="max-w-md w-full text-center">
        <h1 class="text-4xl font-black text-purple-500 uppercase tracking-tighter mb-8">QuickfitZe</h1>
        
        <div class="bg-[#1a1625] p-8 rounded-3xl border border-white/5 shadow-2xl text-left">
            <h2 class="text-lg font-bold mb-6">Athlete Login</h2>
            
            <?php if($error): ?>
                <p class="text-red-400 text-xs mb-4"><?php echo $error; ?></p>
            <?php endif; ?>

            <form method="POST" class="space-y-4">
                <input type="text" name="username" placeholder="Username" required class="w-full bg-[#0f0c14] border border-gray-800 p-4 rounded-2xl text-sm outline-none focus:border-purple-500">
                <input type="password" name="password" placeholder="Password" required class="w-full bg-[#0f0c14] border border-gray-800 p-4 rounded-2xl text-sm outline-none focus:border-purple-500">
                <button type="submit" class="w-full bg-white text-black font-black py-4 rounded-2xl hover:bg-purple-500 hover:text-white transition-all uppercase text-xs tracking-widest">
                    Enter Console
                </button>
            </form>
            <p class="text-center text-gray-500 text-[10px] mt-6 uppercase tracking-widest">
                Not a member? <a href="member_register.php" class="text-purple-400 font-bold">Join now</a>
            </p>
        </div>
    </div>
</body>
</html>