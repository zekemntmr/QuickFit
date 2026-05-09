<?php
include 'connectiondb.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure hashing
    $plan_id = $_POST['plan_id'];

    // 1. Insert into 'members' table first
    $sql_member = "INSERT INTO members (fname, lname, plan_id) VALUES ('$fname', '$lname', '$plan_id')";
    
    if ($conn->query($sql_member) === TRUE) {
        $new_member_id = $conn->insert_id; // Get the ID created for this member

        // 2. Insert into 'member_accounts' table using that ID
        $sql_account = "INSERT INTO member_accounts (member_id, username, password) VALUES ('$new_member_id', '$username', '$password')";
        
        if ($conn->query($sql_account) === TRUE) {
            $message = "success";
        }
    } else {
        $message = "error";
    }
}

?>

<!DOCTYPE html>
<html class="dark">
<head>
    <title>QuickfitZe | Member Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0f0c14] text-white flex items-center justify-center min-h-screen p-6">
    <div class="max-w-md w-full bg-[#1a1625] p-8 rounded-3xl border border-purple-500/20 shadow-2xl">
        <h1 class="text-2xl font-black text-purple-400 uppercase mb-2">Create Athlete Account</h1>
        <p class="text-gray-400 text-xs mb-6">Join the roster and access your performance stats.</p>

        <?php if($message == "success"): ?>
            <div class="bg-green-500/10 border border-green-500 text-green-400 p-4 rounded-xl mb-6 text-sm">
                Account created! <a href="member_login.php" class="font-bold underline">Login here</a>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div class="grid grid-cols-2 gap-3">
                <input type="text" name="fname" placeholder="First Name" required class="bg-[#0f0c14] border border-gray-700 p-3 rounded-xl text-sm focus:border-purple-500 outline-none">
                <input type="text" name="lname" placeholder="Last Name" required class="bg-[#0f0c14] border border-gray-700 p-3 rounded-xl text-sm focus:border-purple-500 outline-none">
            </div>
            <input type="text" name="username" placeholder="Choose Username" required class="w-full bg-[#0f0c14] border border-gray-700 p-3 rounded-xl text-sm focus:border-purple-500 outline-none">
            <input type="password" name="password" placeholder="Password" required class="w-full bg-[#0f0c14] border border-gray-700 p-3 rounded-xl text-sm focus:border-purple-500 outline-none">
            
            <select name="plan_id" class="w-full bg-[#0f0c14] border border-gray-700 p-3 rounded-xl text-sm text-gray-400">
                <option value="1">Basic Plan - ₱2,500</option>
                <option value="2">Pro Plan - ₱4,500</option>
                <option value="3">Elite Plan - ₱7,500</option>
            </select>

            <button type="submit" class="w-full bg-purple-600 hover:bg-purple-500 text-white font-black py-3 rounded-xl transition-all uppercase tracking-widest text-xs">
                Create Account
            </button>
        </form>
    </div>
</body>
</html>