<?php
session_start();
include 'connectiondb.php'; // Ensure this file has the correct DB name
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    // This queries your actual 'admins' table
    $query = "SELECT * FROM admins WHERE username = '$user' AND password = '$pass'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $_SESSION['user'] = $user;
        header("Location: dashboard.php"); 
        exit();
    } else {
        $error = "Access Denied. Check credentials.";
    }
}

?>

<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickfitZe | Admin Access</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">

    <script>
  tailwind.config = {
    darkMode: "class",
    theme: {
      extend: {
        colors: {
          "primary": "#d5baff", /* Hardcode here as a fallback */
          "background": "#0a090c",
          "surface-container-high": "#1a181e",
          "outline-variant": "#2d2a33"
        }
      }
    }
  }
</script>   
</head>
<body class="bg-background text-on-background flex items-center justify-center min-h-screen relative overflow-hidden">

    <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] bg-primary/20 rounded-full blur-[120px] z-0"></div>
    <div class="absolute bottom-[-20%] right-[-10%] w-[500px] h-[500px] bg-primary-container/30 rounded-full blur-[120px] z-0"></div>

    <div class="relative z-10 w-full max-w-md px-6">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-black tracking-tighter text-primary uppercase drop-shadow-[0_0_10px_rgba(213,186,255,0.4)]">
                Quickfit<span class="text-on-background">Ze</span>
            </h1>
            <p class="text-xs font-label-caps text-primary/70 mt-2 tracking-[0.3em]">Management Portal</p>
        </div>

        <div class="bg-surface-container-high/60 border border-primary/20 p-10 rounded-3xl backdrop-blur-xl shadow-[0_20px_50px_rgba(0,0,0,0.5)]">
            <form action="login.php" method="POST" class="space-y-6">
                
                <?php if($error): ?>
                    <div class="bg-red-500/20 border border-red-500/50 text-red-400 text-xs p-3 rounded-lg text-center font-bold">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <div>
                    <label class="block text-[10px] font-label-caps text-primary mb-2">Admin Username</label>
                    <input type="text" name="username" required
                        class="w-full bg-background/50 border border-outline-variant rounded-xl px-4 py-4 focus:outline-none focus:border-primary transition-all text-on-surface placeholder:text-outline/50"
                        placeholder="e.g. admin">
                </div>

                <div>
                    <label class="block text-[10px] font-label-caps text-primary mb-2">Secure Password</label>
                    <input type="password" name="password" required
                        class="w-full bg-background/50 border border-outline-variant rounded-xl px-4 py-4 focus:outline-none focus:border-primary transition-all text-on-surface placeholder:text-outline/50"
                        placeholder="••••••••">

                        
                </div>

                <button type="submit" 
                    class="w-full bg-primary text-primary-container font-black py-4 rounded-xl hover:scale-[1.02] active:scale-[0.98] transition-all uppercase tracking-widest text-xs shadow-[0_0_30px_rgba(213,186,255,0.3)] mt-4">
                    Authenticate
                </button>
            </form>

            <div class="mt-8 text-center">
                <a href="index.php" class="text-[10px] font-label-caps text-on-surface-variant hover:text-primary transition-colors">
                    ← Return to Home
                </a>
            </div>
        </div>
    </div>

</body>
</html>