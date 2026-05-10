<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>QuickfitZe | Gym Membership Tracker</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="style.css">

    <script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "primary": "var(--primary)",
              "primary-container": "var(--primary-container)",
              "on-primary-container": "var(--on-primary-container)",
              "background": "var(--background)",
              "surface": "var(--surface)",
              "surface-container-low": "var(--surface-container-low)",
              "surface-container-lowest": "var(--surface-container-lowest)",
              "surface-container-high": "var(--surface-container-high)",
              "on-background": "var(--on-background)",
              "on-surface": "var(--on-surface)",
              "on-surface-variant": "var(--on-surface-variant)",
              "outline": "var(--outline)",
              "outline-variant": "var(--outline-variant)",
            }
          }
        }
      }
    </script>
</head>
<body class="bg-background text-on-background antialiased">

    <header class="fixed top-0 z-50 w-full bg-surface-container-low/80 backdrop-blur-md border-b border-outline-variant flex justify-between items-center px-10 py-4">
        <div class="text-2xl font-black tracking-tighter text-primary uppercase">QuickfitZe</div>
        
        <nav class="hidden md:flex items-center gap-8">
            <a class="text-on-surface-variant text-xs font-bold uppercase tracking-widest hover:text-primary transition-all" href="#memberships">Memberships</a>
            <a class="text-on-surface-variant text-xs font-bold uppercase tracking-widest hover:text-primary transition-all" href="trainers.php">Trainers</a>
        </nav>

        <div class="flex items-center gap-4">
            <button onclick="window.location.href='member_login.php'" class="text-xs font-bold px-4 py-2 text-on-surface-variant hover:text-primary transition-all uppercase tracking-widest">Login</button>
            <button onclick="window.location.href='member_register.php'" class="bg-primary text-background text-xs font-bold px-6 py-2 hover:opacity-90 transition-all uppercase tracking-widest">Join Now</button>
        </div>
    </header>

    <main>
        <section class="relative h-[90vh] flex items-center overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img class="w-full h-full object-cover opacity-30 mix-blend-luminosity" src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&q=80" alt="Gym Hero"/>
                <div class="absolute inset-0 bg-gradient-to-t from-background via-transparent to-transparent"></div>
            </div>
            
            <div class="relative z-10 px-10 w-full max-w-5xl">
                <div class="space-y-6">
                    <span class="inline-block text-xs font-bold text-primary border-l-4 border-primary pl-4 tracking-[0.3em] uppercase">The Athlete's Portal</span>
                    <h1 class="text-6xl md:text-8xl font-black text-on-background leading-none uppercase tracking-tighter">THE ROSTER<br>AWAITS.</h1>
                    <p class="text-lg text-on-surface-variant max-w-xl">Whether you are a rising athlete or a system administrator, your journey to elite performance starts here.</p>
                    
                    <div class="flex flex-wrap gap-4 pt-4">
                        <button onclick="window.location.href='member_register.php'" class="bg-primary text-background px-10 py-5 font-black hover:scale-105 transition-all uppercase tracking-widest text-xs">Register as Athlete</button>
                        <button onclick="window.location.href='login.php'" class="border border-outline text-on-background px-10 py-5 font-black hover:bg-white hover:text-black transition-all uppercase tracking-widest text-xs">Admin Console</button>
                    </div>
                </div>
            </div>
        </section>

        <section id="memberships" class="py-32 px-10">
            <div class="text-center max-w-2xl mx-auto mb-20 space-y-4">
                <h2 class="text-4xl font-black uppercase tracking-tight text-primary">Membership Tiers</h2>
                <p class="text-on-surface-variant uppercase text-xs tracking-widest">Select your level of intensity</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-surface-container-high border border-outline-variant p-10 flex flex-col hover:border-primary transition-all rounded-3xl">
                    <span class="text-xs font-bold text-primary tracking-widest uppercase mb-4">Basic</span>
                    <div class="text-4xl font-black mb-8">₱2,500 <span class="text-xs text-on-surface-variant font-normal">/mo</span></div>
                    <ul class="space-y-4 mb-10 flex-grow text-sm text-on-surface-variant">
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-sm">check_circle</span> Gym Floor Access</li>
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-sm">check_circle</span> Locker Access</li>
                    </ul>
                    <button onclick="window.location.href='member_register.php'" class="w-full border-2 border-primary text-primary py-4 font-black text-xs uppercase tracking-widest hover:bg-primary hover:text-background transition-all rounded-xl">Select Tier</button>
                </div>

                <div class="bg-surface-container-high border-2 border-primary p-10 flex flex-col relative md:scale-110 z-10 rounded-3xl shadow-2xl shadow-primary/10">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-primary text-background text-[10px] font-black px-4 py-1 tracking-widest">MOST POPULAR</div>
                    <span class="text-xs font-bold text-primary tracking-widest uppercase mb-4">Premium</span>
                    <div class="text-4xl font-black mb-8">₱4,500 <span class="text-xs text-on-surface-variant font-normal">/mo</span></div>
                    <ul class="space-y-4 mb-10 flex-grow text-sm text-white">
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-sm">check_circle</span> Unlimited HIIT Classes</li>
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-sm">check_circle</span> Monthly Trainer Session</li>
                    </ul>
                    <button onclick="window.location.href='member_register.php'" class="w-full bg-primary text-background py-4 font-black text-xs uppercase tracking-widest hover:opacity-90 transition-all rounded-xl">Select Tier</button>
                </div>

                <div class="bg-surface-container-high border border-outline-variant p-10 flex flex-col hover:border-primary transition-all rounded-3xl">
                    <span class="text-xs font-bold text-primary tracking-widest uppercase mb-4">Elite</span>
                    <div class="text-4xl font-black mb-8">₱7,500 <span class="text-xs text-on-surface-variant font-normal">/mo</span></div>
                    <ul class="space-y-4 mb-10 flex-grow text-sm text-on-surface-variant">
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-sm">check_circle</span> 24/7 VIP Access</li>
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-sm">check_circle</span> Weekly PT Sessions</li>
                    </ul>
                    <button onclick="window.location.href='member_register.php'" class="w-full border-2 border-primary text-primary py-4 font-black text-xs uppercase tracking-widest hover:bg-primary hover:text-background transition-all rounded-xl">Select Tier</button>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-surface-container-lowest border-t border-outline-variant px-10 py-12">
        <div class="flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="text-2xl font-black text-primary uppercase">QuickfitZe</div>
            <div class="flex gap-8">
                <a class="text-on-surface-variant text-[10px] font-bold uppercase tracking-widest hover:text-primary" href="member_login.php">Athlete Login</a>
                <a class="text-on-surface-variant text-[10px] font-bold uppercase tracking-widest hover:text-primary" href="login.php">Staff Login</a>
            </div>
            <div class="text-[10px] text-on-surface-variant uppercase tracking-widest">
                © 2026 QUICKFITZE ELITE. 
            </div>
        </div>
    </footer>

</body>
</html>