<?php
include 'connectiondb.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $plan_id = $_POST['plan_id'];

    /* 1. Insert into members table */
    $sql_member = "INSERT INTO members (fname, lname, plan_id) VALUES ('$fname', '$lname', '$plan_id')";
    
    if ($conn->query($sql_member) === TRUE) {
        $new_id = $conn->insert_id;
        /* 2. Create the login account linked to that member ID */
        $sql_acc = "INSERT INTO member_accounts (member_id, username, password) VALUES ('$new_id', '$username', '$password')";
        if ($conn->query($sql_acc) === TRUE) {
            $message = "success";
        }
    } else {
        $message = "error";
    }
}
?>

<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="UTF-8">
    <title>QuickfitZe | Join the Roster</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css"> </head>
<body class="min-h-screen flex items-center justify-center p-6">

    <div class="max-w-md w-full bg-surface border border-outline-variant p-8 rounded-[2rem] shadow-2xl">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-primary uppercase tracking-tighter">QuickfitZe</h1>
            <p class="text-[10px] text-on-surface-variant uppercase tracking-[0.3em] mt-1">Athlete Registration</p>
        </div>

        <?php if($message == "success"): ?>
            <div class="bg-primary/10 border border-primary text-primary p-4 rounded-xl mb-6 text-xs text-center font-bold">
                ACCOUNT VERIFIED! <a href="member_login.php" class="underline ml-1">LOG IN HERE</a>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-[10px] uppercase text-primary font-bold ml-1">First Name</label>
                    <input type="text" name="fname" required class="w-full p-3 rounded-xl text-sm">
                </div>
                <div>
                    <label class="text-[10px] uppercase text-primary font-bold ml-1">Last Name</label>
                    <input type="text" name="lname" required class="w-full p-3 rounded-xl text-sm">
                </div>
            </div>

            <div>
                <label class="text-[10px] uppercase text-primary font-bold ml-1">Username</label>
                <input type="text" name="username" required class="w-full p-3 rounded-xl text-sm">
            </div>

            <div>
                <label class="text-[10px] uppercase text-primary font-bold ml-1">Password</label>
                <input type="password" name="password" required class="w-full p-3 rounded-xl text-sm">
            </div>

            <div>
                <label class="text-[10px] uppercase text-primary font-bold ml-1">Membership Plan</label>
                <select name="plan_id" class="w-full p-3 rounded-xl text-sm">
                    <option value="1">BASIC TIER - ₱2,500</option>
                    <option value="2">PRO TIER - ₱4,500</option>
                    <option value="3">ELITE TIER - ₱7,500</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-primary text-background font-black py-4 rounded-xl hover:opacity-90 transition-all text-xs uppercase tracking-widest mt-2">
                Create Account
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-outline-variant text-center">
            <p class="text-[10px] text-on-surface-variant uppercase tracking-widest">
                Already have an account? 
                <a href="member_login.php" class="text-primary font-bold hover:underline transition-all">Log in</a>
            </p>
        </div>
    </div>

</body>
</html>