<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>QuickfitZe | Elite Performance</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
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
            },
            spacing: {
              "margin": "40px",
              "gutter": "24px",
              "card-padding": "32px"
            }
          }
        }
      }
    </script>
</head>
<body class="bg-background text-on-background antialiased">

    <header class="fixed top-0 z-50 w-full bg-surface-container-low border-b border-outline-variant flex justify-between items-center px-margin py-4">
        <div class="text-2xl font-black tracking-tighter text-primary uppercase">QuickfitZe</div>
        <nav class="hidden md:flex items-center gap-8">
            <a class="text-on-surface-variant font-medium text-xs font-label-caps hover:text-primary transition-all" href="#">Classes</a>
            <a class="text-on-surface-variant font-medium text-xs font-label-caps hover:text-primary transition-all" href="#">Memberships</a>
            <a class="text-on-surface-variant font-medium text-xs font-label-caps hover:text-primary transition-all" href="#">Trainers</a>
            <a class="text-on-surface-variant font-medium text-xs font-label-caps hover:text-primary transition-all" href="#">Schedule</a>
        </nav>
        <div class="flex items-center gap-4">
            <button onclick="window.location.href='login.php'" class="text-xs font-label-caps font-bold px-4 py-2 text-on-surface-variant hover:text-primary transition-all">Login</button>
            <button class="bg-primary-container text-on-primary-container text-xs font-label-caps font-bold px-6 py-2 hover:opacity-90 transition-all">Join Now</button>
        </div>
    </header>

    <main class="pt-20">
        <section class="relative h-[80vh] flex items-center overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img class="w-full h-full object-cover opacity-40 mix-blend-luminosity" src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&q=80" alt="Athlete Silhouette"/>
                <div class="absolute inset-0 bg-gradient-to-r from-background via-background/40 to-transparent"></div>
            </div>
            <div class="relative z-10 px-margin w-full max-w-5xl">
                <div class="space-y-6">
                    <span class="inline-block text-xs font-label-caps text-primary border-l-4 border-primary pl-4 tracking-[0.2em]">ELITE PERFORMANCE PLATFORM</span>
                    <h1 class="text-5xl md:text-7xl font-extrabold text-on-background leading-none uppercase">UNLEASH<br>YOUR POTENTIAL</h1>
                    <p class="text-lg text-on-surface-variant max-w-xl">Access world-class training, elite coaches, and a community of high-performers.</p>
                    <div class="flex gap-4 pt-4">
                        <button class="bg-primary-container text-on-primary-container px-8 py-4 font-bold hover:opacity-90 transition-all">Start Your Journey</button>
                        <button class="border border-outline text-on-background px-8 py-4 font-bold hover:border-primary transition-all">Explore Classes</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-24 px-margin">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                <h2 class="text-3xl font-bold">Tiered Access Plans</h2>
                <p class="text-on-surface-variant">Choose the level of intensity that matches your ambition.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                
                <div class="bg-surface-container-high border border-outline-variant p-card-padding flex flex-col hover:border-primary transition-all">
                    <div class="mb-8">
                        <span class="text-xs font-label-caps text-primary">BASIC</span>
                        <div class="flex items-baseline gap-1 mt-2">
                            <span class="text-3xl font-bold">$49</span>
                            <span class="text-on-surface-variant">/mo</span>
                        </div>
                    </div>
                    <ul class="space-y-4 mb-10 flex-grow text-sm">
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-lg">check_circle</span> Gym Floor Access</li>
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-lg">check_circle</span> Locker Room & Showers</li>
                    </ul>
                    <button class="w-full border border-primary text-primary py-4 font-bold hover:bg-primary hover:text-background transition-all">SELECT PLAN</button>
                </div>

                <div class="bg-surface-container-high border-2 border-primary p-card-padding flex flex-col relative md:scale-110 z-10">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-primary text-background text-[10px] font-bold px-4 py-1">MOST POPULAR</div>
                    <div class="mb-8">
                        <span class="text-xs font-label-caps text-primary">PRO</span>
                        <div class="flex items-baseline gap-1 mt-2">
                            <span class="text-3xl font-bold">$89</span>
                            <span class="text-on-surface-variant">/mo</span>
                        </div>
                    </div>
                    <ul class="space-y-4 mb-10 flex-grow text-sm">
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-lg">check_circle</span> All Basic Features</li>
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-lg">check_circle</span> Unlimited HIIT Classes</li>
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-lg">check_circle</span> Monthly Trainer Session</li>
                    </ul>
                    <button class="w-full bg-primary text-background py-4 font-bold hover:opacity-90 transition-all">JOIN NOW</button>
                </div>

                <div class="bg-surface-container-high border border-outline-variant p-card-padding flex flex-col hover:border-primary transition-all">
                    <div class="mb-8">
                        <span class="text-xs font-label-caps text-primary">ELITE</span>
                        <div class="flex items-baseline gap-1 mt-2">
                            <span class="text-3xl font-bold">$149</span>
                            <span class="text-on-surface-variant">/mo</span>
                        </div>
                    </div>
                    <ul class="space-y-4 mb-10 flex-grow text-sm">
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-lg">check_circle</span> 24/7 VIP Access</li>
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-lg">check_circle</span> Weekly Personal Training</li>
                        <li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-lg">check_circle</span> Recovery Lounge Access</li>
                    </ul>
                    <button class="w-full border border-primary text-primary py-4 font-bold hover:bg-primary hover:text-background transition-all">SELECT PLAN</button>
                </div>

            </div>
        </section>
    </main>

    <footer class="bg-surface-container-lowest border-t border-outline-variant flex flex-col md:flex-row justify-between items-center px-margin py-8 gap-8">
        <div class="text-xl font-black text-primary uppercase">QuickfitZe</div>
        <div class="text-sm text-on-surface-variant">© 2024 QUICKFITZE. NO EXCUSES.</div>
    </footer>

</body>
</html>