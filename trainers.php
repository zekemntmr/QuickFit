<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>QuickfitZe | Elite Trainers</title>
    
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                "secondary-container": "#52358b",
                "outline": "#968d9e",
                "background": "#0f0c14",
                "surface": "#131313",
                "on-surface": "#e5e2e1",
                "primary": "#d5baff",
                "on-primary": "#42008a",
                "surface-container-high": "#2a2a2a",
                "surface-container-low": "#1c1b1b",
                "surface-container-lowest": "#0e0e0e",
                "outline-variant": "#4a4453",
                "on-surface-variant": "#cdc3d5",
            },
            "spacing": {
                "unit": "4px",
                "card-padding": "32px",
                "margin": "40px",
                "gutter": "24px"
            }
          },
        },
      }
    </script>
</head>
<body class="bg-background text-on-background antialiased">

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

    <main class="pt-20">
        <section class="relative w-full h-[500px] flex items-center px-margin overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img class="w-full h-full object-cover opacity-30 mix-blend-luminosity" alt="Coaching staff" src="https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?auto=format&fit=crop&q=80"/>
                <div class="absolute inset-0 bg-gradient-to-r from-background via-background/80 to-transparent"></div>
            </div>
            <div class="relative z-10 max-w-3xl">
                <span class="inline-block border-l-4 border-primary pl-4 text-primary text-[10px] font-bold uppercase tracking-[0.3em] mb-6">Architects of Performance</span>
                <h1 class="text-6xl md:text-8xl font-black text-on-surface uppercase mb-6 tracking-tighter leading-none">THE <span class="text-primary">ELITE</span> ROSTER</h1>
                <p class="text-lg text-on-surface-variant mb-8 max-w-xl">
                    Our trainers are world-class athletes and biomechanics experts dedicated to breaking your limits.
                </p>
            </div>
        </section>

        <section class="px-margin py-6 bg-surface-container-lowest border-y border-outline-variant sticky top-[72px] z-40 overflow-x-auto">
            <div class="flex items-center gap-8 min-w-max">
                <span class="text-[10px] font-bold text-outline tracking-widest">FILTER BY SPECIALTY:</span>
                <button class="bg-primary text-background px-6 py-2 text-[10px] font-black uppercase tracking-widest">All Trainers</button>
            </div>
        </section>

        <section class="px-margin py-20">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                
                <div class="group border border-outline-variant bg-surface-container-low hover:border-primary transition-all duration-500 rounded-[2rem] overflow-hidden shadow-2xl">
                    <div class="relative aspect-[3/4] overflow-hidden">
                        <img class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 group-hover:scale-110" alt="Trainer" src="zustin.jpg"/>
                        <div class="absolute top-6 left-6">
                            <span class="bg-primary text-background text-[10px] font-black px-4 py-2 uppercase tracking-widest">Master Coach</span>
                        </div>
                    </div>
                    <div class="p-8">
                        <h3 class="text-3xl font-black text-on-surface uppercase mb-1 tracking-tighter">Zustin 'Oppa' Añasco</h3>
                        <p class="text-[10px] font-bold text-primary mb-6 uppercase tracking-widest">Strength & Conditioning</p>
                        <p class="text-sm text-on-surface-variant mb-8 line-clamp-3 leading-relaxed">
                            Specializing in explosive power and progressive overload. Trained Olympic-level athletes and professional competitors.
                        </p>
                        <div class="flex justify-between items-center pt-6 border-t border-outline-variant">
                            <div class="flex gap-4">
                                <span class="material-symbols-outlined text-outline hover:text-primary cursor-pointer">share</span>
                                <span class="material-symbols-outlined text-outline hover:text-primary cursor-pointer">calendar_today</span>
                            </div>
                            <a class="text-[10px] font-black text-on-surface group-hover:text-primary transition-colors flex items-center gap-2 uppercase tracking-widest" href="#">
                                View Bio <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="group border border-outline-variant bg-surface-container-low hover:border-primary transition-all duration-500 rounded-[2rem] overflow-hidden shadow-2xl">
                    <div class="relative aspect-[3/4] overflow-hidden">
                        <img class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 group-hover:scale-110" alt="Trainer" src="img/ezeshas.jpg"/>
                        <div class="absolute top-6 left-6">
                            <span class="bg-primary text-background text-[10px] font-black px-4 py-2 uppercase tracking-widest">Master Coach</span>
                        </div>
                    </div>
                    <div class="p-8">
                        <h3 class="text-3xl font-black text-on-surface uppercase mb-1 tracking-tighter">Ezechias 'Zeke' Montemor</h3>
                        <p class="text-[10px] font-bold text-primary mb-6 uppercase tracking-widest">Endurance</p>
                        <p class="text-sm text-on-surface-variant mb-8 line-clamp-3 leading-relaxed">
                            Specializing in Muscle Endurance. Trained National-level athletes and professional athletes.
                        </p>
                        <div class="flex justify-between items-center pt-6 border-t border-outline-variant">
                            <div class="flex gap-4">
                                <span class="material-symbols-outlined text-outline hover:text-primary cursor-pointer">share</span>
                                <span class="material-symbols-outlined text-outline hover:text-primary cursor-pointer">calendar_today</span>
                            </div>
                            <a class="text-[10px] font-black text-on-surface group-hover:text-primary transition-colors flex items-center gap-2 uppercase tracking-widest" href="#">
                                View Bio <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>

                </div>
        </section>
    </main>

    <footer class="flex flex-col md:flex-row justify-between items-center px-margin py-12 border-t border-outline-variant bg-surface-container-lowest">
        <div class="text-2xl font-black text-primary uppercase">QUICKFITZE</div>
        <div class="flex gap-8 mb-6 md:mb-0">
            <a class="text-on-surface-variant text-[10px] font-bold uppercase tracking-widest hover:text-primary" href="member_login.php">Athlete Portal</a>
            <a class="text-on-surface-variant text-[10px] font-bold uppercase tracking-widest hover:text-primary" href="login.php">Staff Access</a>
        </div>
        <div class="text-[10px] text-on-surface-variant opacity-60 uppercase tracking-widest">
            © 2026 QUICKFITZE. NO EXCUSES.
        </div>
    </footer>
</body>
</html>