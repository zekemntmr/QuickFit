<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    
    <!-- External Styles -->
    <link rel="stylesheet" href="style.css">
    
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- Tailwind Custom Configuration -->
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "secondary-container": "#52358b",
                    "outline": "#968d9e",
                    "surface-dim": "#131313",
                    "on-error-container": "#ffdad6",
                    "error-container": "#93000a",
                    "background": "#131313",
                    "on-secondary-container": "#c3a6ff",
                    "on-primary-fixed": "#270057",
                    "secondary": "#d2bbff",
                    "on-tertiary-fixed-variant": "#49454f",
                    "tertiary": "#cbc4d1",
                    "surface-container-highest": "#353534",
                    "surface-container": "#201f1f",
                    "surface": "#131313",
                    "secondary-fixed-dim": "#d2bbff",
                    "on-tertiary": "#322f38",
                    "on-primary-fixed-variant": "#5b20ab",
                    "primary-fixed-dim": "#d5baff",
                    "inverse-primary": "#743fc4",
                    "on-tertiary-container": "#c4bdca",
                    "on-surface": "#e5e2e1",
                    "on-primary": "#42008a",
                    "surface-tint": "#d5baff",
                    "on-surface-variant": "#cdc3d5",
                    "error": "#ffb4ab",
                    "primary": "#d5baff",
                    "tertiary-fixed": "#e7e0ed",
                    "tertiary-fixed-dim": "#cbc4d1",
                    "tertiary-container": "#504c57",
                    "surface-container-high": "#2a2a2a",
                    "secondary-fixed": "#eaddff",
                    "on-secondary-fixed": "#25005a",
                    "inverse-surface": "#e5e2e1",
                    "primary-fixed": "#ecdcff",
                    "inverse-on-surface": "#313030",
                    "on-secondary": "#3b1c73",
                    "on-primary-container": "#d0b2ff",
                    "surface-container-low": "#1c1b1b",
                    "on-secondary-fixed-variant": "#52358b",
                    "on-background": "#e5e2e1",
                    "surface-bright": "#3a3939",
                    "surface-variant": "#353534",
                    "on-tertiary-fixed": "#1d1a23",
                    "surface-container-lowest": "#0e0e0e",
                    "primary-container": "#632bb3",
                    "outline-variant": "#4a4453",
                    "on-error": "#690005"
            },
            "borderRadius": {
                    "DEFAULT": "0.125rem",
                    "lg": "0.25rem",
                    "xl": "0.5rem",
                    "full": "0.75rem"
            },
            "spacing": {
                    "unit": "4px",
                    "card-padding": "32px",
                    "margin": "40px",
                    "gutter": "24px"
            },
            "fontFamily": {
                    "body-md": ["Inter"],
                    "label-caps": ["Space Grotesk"],
                    "headline-md": ["Inter"],
                    "headline-lg": ["Inter"],
                    "headline-xl": ["Inter"],
                    "body-lg": ["Inter"]
            },
            "fontSize": {
                    "body-md": ["16px", {"lineHeight": "1.6", "fontWeight": "400"}],
                    "label-caps": ["12px", {"lineHeight": "1.0", "letterSpacing": "0.1em", "fontWeight": "600"}],
                    "headline-md": ["24px", {"lineHeight": "1.2", "fontWeight": "700"}],
                    "headline-lg": ["32px", {"lineHeight": "1.2", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                    "headline-xl": ["48px", {"lineHeight": "1.1", "letterSpacing": "-0.04em", "fontWeight": "800"}],
                    "body-lg": ["18px", {"lineHeight": "1.6", "fontWeight": "400"}]
            }
          },
        },
      }
    </script>
</head>
<body class="bg-background text-on-background font-body-md selection:bg-primary selection:text-on-primary">

    <!-- TopNavBar -->
    <nav class="fixed top-0 z-50 flex justify-between items-center w-full px-margin py-4 max-w-full border-b border-outline-variant bg-surface-container-low">
        <div class="text-headline-md font-headline-md font-black tracking-tighter text-primary uppercase">QuickfitZe</div>
        
        <!-- Desktop Nav -->
        <div class="hidden md:flex gap-gutter items-center">
            <a class="text-on-surface-variant font-medium hover:text-primary hover:border-primary transition-all duration-200 text-label-caps font-label-caps" href="#">Classes</a>
            <a class="text-on-surface-variant font-medium hover:text-primary hover:border-primary transition-all duration-200 text-label-caps font-label-caps" href="#">Memberships</a>
            <a class="text-primary border-b-2 border-primary pb-1 text-label-caps font-label-caps" href="#">Trainers</a>
            <a class="text-on-surface-variant font-medium hover:text-primary hover:border-primary transition-all duration-200 text-label-caps font-label-caps" href="#">Schedule</a>
        </div>

        <div class="flex items-center gap-4">
            <div class="hidden lg:flex items-center bg-surface-container-high px-4 py-2 border-b border-outline focus-within:border-primary transition-all">
                <span class="material-symbols-outlined text-outline text-[20px]">search</span>
                <input class="bg-transparent border-none focus:ring-0 text-label-caps font-label-caps placeholder:text-outline text-on-surface" placeholder="SEARCH TRAINERS" type="text"/>
            </div>
            <button class="bg-primary text-on-primary font-label-caps text-label-caps px-6 py-3 rounded-none uppercase hover:opacity-90 active:scale-95 transition-all">Join Now</button>
        </div>
    </nav>

    <main class="pt-24">
        <!-- Hero Section -->
        <section class="relative w-full h-[614px] flex items-center px-margin overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img class="w-full h-full object-cover opacity-40" alt="Elite fitness coaching staff" src="https://lh3.googleusercontent.com/aida-public/AB6AXuByW-XY2pvTugqq9m4Y9QXig8nbB8819PokOIVa8Gvgpd3IszF2fLEOl7n11i_NDOWDVLQAqr_xJgw5GQyihBs-OZJZaC65jyymKgfmjVg7eGcfX7amyW5FSRwrhgYSs0P4hvtuOao-Uoh2F6NDNqgGtzkMWHW7wxZhVWVIleFDxWoKaCjge9HQrQpqbzPi3ugaMT3YIjBu7W6VpN5dZnmxk_0y8T7i5az_ES-O8-shhfN3YB-_LfoV1Sab6vbV7K3RMjiUGqUgx7OE"/>
                <div class="absolute inset-0 bg-gradient-to-r from-background via-background/80 to-transparent"></div>
            </div>
            <div class="relative z-10 max-w-3xl">
                <span class="inline-block bg-secondary-container text-on-secondary-container text-label-caps font-label-caps px-4 py-1 mb-6">ELITE COACHING STAFF</span>
                <h1 class="text-headline-xl font-headline-xl text-on-surface uppercase mb-6">The Architects of <span class="text-primary">Performance</span></h1>
                <p class="text-body-lg font-body-lg text-on-surface-variant mb-8 max-w-xl">
                    Our trainers aren't just instructors—they are world-class athletes, nutritionists, and biomechanics experts dedicated to breaking your limits.
                </p>
                <div class="flex gap-4">
                    <button class="bg-primary text-on-primary px-8 py-4 font-label-caps text-label-caps uppercase hover:opacity-90 transition-all">Book Assessment</button>
                    <button class="border border-outline text-on-surface px-8 py-4 font-label-caps text-label-caps uppercase hover:bg-surface-container-high transition-all">View Schedule</button>
                </div>
            </div>
        </section>

        <!-- Filter Bar -->
        <section class="px-margin py-8 bg-surface-container-lowest border-y border-outline-variant sticky top-[72px] z-40 overflow-x-auto">
            <div class="flex items-center gap-gutter min-w-max">
                <span class="text-label-caps font-label-caps text-outline mr-4">FILTER BY SPECIALTY:</span>
                <button class="bg-primary text-on-primary px-6 py-2 font-label-caps text-label-caps uppercase">All Trainers</button>
                <button class="text-on-surface-variant hover:text-primary px-6 py-2 font-label-caps text-label-caps uppercase transition-colors">Strength & Conditioning</button>
                <button class="text-on-surface-variant hover:text-primary px-6 py-2 font-label-caps text-label-caps uppercase transition-colors">HIIT</button>
                <button class="text-on-surface-variant hover:text-primary px-6 py-2 font-label-caps text-label-caps uppercase transition-colors">Yoga & Mobility</button>
                <button class="text-on-surface-variant hover:text-primary px-6 py-2 font-label-caps text-label-caps uppercase transition-colors">Nutrition</button>
            </div>
        </section>

        <!-- Trainers Grid -->
        <section class="px-margin py-20 bg-background">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                
                <!-- Trainer Card 1 -->
                <div class="group border border-outline-variant bg-surface-container hover:border-primary transition-all duration-300">
                    <div class="relative aspect-[3/4] overflow-hidden">
                        <img class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500 group-hover:scale-105" alt="Marcus Vane - Strength" src="zustin.jpg"/>
                        <div class="absolute top-4 left-4">
                            <span class="bg-primary text-on-primary text-label-caps font-label-caps px-3 py-1">STRENGTH</span>
                        </div>
                    </div>
                    <div class="p-card-padding">
                        <h3 class="text-headline-md font-headline-md text-on-surface uppercase mb-2">Zustin 'Oppa' Añasco</h3>
                        <p class="text-label-caps font-label-caps text-primary mb-4">Master Strength & Conditioning Coach</p>
                        <p class="text-body-md font-body-md text-on-surface-variant mb-6 line-clamp-3">
                            Specializing in explosive power and progressive overload. Marcus has trained Olympic lifters and professional athletes for over a decade.
                        </p>
                        <div class="flex justify-between items-center pt-6 border-t border-outline-variant">
                            <div class="flex gap-4">
                                <span class="material-symbols-outlined text-outline hover:text-primary cursor-pointer text-[20px]">share</span>
                                <span class="material-symbols-outlined text-outline hover:text-primary cursor-pointer text-[20px]">calendar_today</span>
                            </div>
                            <a class="text-label-caps font-label-caps text-on-surface group-hover:text-primary transition-colors flex items-center gap-2" href="#">
                                VIEW PROFILE <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- (Other Trainer Cards follow same structure...) -->
                <!-- Trainer Card 2 -->
                <div class="group border border-outline-variant bg-surface-container hover:border-primary transition-all duration-300">
                    <div class="relative aspect-[3/4] overflow-hidden">
                        <img class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500 group-hover:scale-105" alt="Sloane Redman - HIIT" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA5MRWWxx04gDTSCVEcdzHYwc-MQ9OqOshMINJKxZnX98Zd5q0NoXinZTNZJ-G7CRrDAuA8HuEZTfaGM82_6KE6vNjnsgSqoMKoqIi4gQRPaxMhe7pweH7zgGmFroX7fugSbvGyIKw2EcPSsypSLjuVoIrtkZmOp8LstGLz32kZgF9RG_8MYJV-kT5qhs5zGur8-W-XmeBJH4KD-sr79CMdzvutqjjawSBIdHQVsRHbudaP_rieQ5Z7gpj37BVwxx2kK34wMSbzP_jQ"/>
                        <div class="absolute top-4 left-4">
                            <span class="bg-primary text-on-primary text-label-caps font-label-caps px-3 py-1">HIIT</span>
                        </div>
                    </div>
                    <div class="p-card-padding">
                        <h3 class="text-headline-md font-headline-md text-on-surface uppercase mb-2">Sloane Redman</h3>
                        <p class="text-label-caps font-label-caps text-primary mb-4">HIIT & Metabolic Specialist</p>
                        <p class="text-body-md font-body-md text-on-surface-variant mb-6 line-clamp-3">
                            High intensity is a lifestyle. Sloane’s sessions are designed to incinerate calories and build mental toughness.
                        </p>
                        <div class="flex justify-between items-center pt-6 border-t border-outline-variant">
                            <div class="flex gap-4">
                                <span class="material-symbols-outlined text-outline hover:text-primary cursor-pointer text-[20px]">share</span>
                                <span class="material-symbols-outlined text-outline hover:text-primary cursor-pointer text-[20px]">calendar_today</span>
                            </div>
                            <a class="text-label-caps font-label-caps text-on-surface group-hover:text-primary transition-colors flex items-center gap-2" href="#">
                                VIEW PROFILE <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- CTA Section -->
        <section class="px-margin py-32 bg-surface-container-low text-center">
            <h2 class="text-headline-lg font-headline-lg uppercase mb-6">Unsure where to start?</h2>
            <p class="text-body-lg font-body-lg text-on-surface-variant mb-10 max-w-2xl mx-auto">
                Take our Athlete Assessment and let our head coach match you with the perfect trainer.
            </p>
            <button class="bg-primary text-on-primary px-12 py-5 font-label-caps text-label-caps uppercase text-[14px] hover:opacity-90 active:scale-95 transition-all">Start My Assessment</button>
        </section>
    </main>

    <!-- Footer -->
    <footer class="flex flex-col md:flex-row justify-between items-center px-margin py-gutter w-full border-t border-outline-variant bg-surface-container-lowest">
        <div class="text-headline-sm font-headline-sm font-black text-primary uppercase mb-6 md:mb-0">QUICKFITZE</div>
        <div class="flex flex-wrap justify-center gap-8 mb-6 md:mb-0">
            <a class="text-on-surface-variant text-label-caps font-label-caps hover:text-on-surface transition-colors duration-200" href="#">Privacy Policy</a>
            <a class="text-on-surface-variant text-label-caps font-label-caps hover:text-on-surface transition-colors duration-200" href="#">Terms of Service</a>
            <a class="text-on-surface-variant text-label-caps font-label-caps hover:text-on-surface transition-colors duration-200" href="#">Contact Support</a>
        </div>
        <div class="text-body-md font-body-md text-on-surface-variant opacity-60">
            © 2024 QUICKFITZE. NO EXCUSES.
        </div>
    </footer>
</body>
</html>