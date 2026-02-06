<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zocco Heritage - Menu Mewah</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&family=Lato:wght@300;400;700&display=swap"
        rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            /* Skema Warna Zocco Heritage (Diambil dari Logo) */
            --color-primary: #2A3654;
            /* Biru Laut Tua (Aksen Kuat) */
            --color-secondary: #E6E8E9;
            /* Abu-abu Sangat Pucat (Latar Belakang) */
            --color-accent: #C6B18D;
            /* Emas Pucat/Khaki (Aksen Lembut/Garis) */
            --color-text: #2A3654;
            /* Biru Tua */
            --color-light-text: #666666;
            /* Untuk deskripsi */
        }

        body {
            /* Menggunakan font Lato dan warna latar Zocco Heritage */
            font-family: 'Lato', sans-serif;
            color: var(--color-text);
            background-color: var(--color-secondary);
            transition: background-color 0.5s, color 0.5s;
        }

        h1,
        h2 {
            /* Menggunakan font Cormorant Garamond untuk Judul Utama */
            font-family: 'Cormorant Garamond', serif;
        }

        h3 {
            /* Menggunakan font Lato untuk Sub-Judul Item Menu */
            font-family: 'Lato', sans-serif;
        }

        /* --- Dark Mode Styles --- */
        .dark-mode {
            background-color: #1c1c1c;
            /* Background sangat gelap */
            color: #E6E8E9;
            /* Text terang */
        }

        /* FIX: Judul utama (H1, H2) harus berubah di Dark Mode agar kontras */
        .dark-mode h1,
        .dark-mode h2 {
            color: var(--color-accent) !important;
            /* Menggunakan Emas Pucat/Khaki */
        }

        .dark-mode .text-gray-900,
        .dark-mode .text-gray-800 {
            color: #E6E8E9;
        }

        /* Mengubah warna elemen terang di Dark Mode */
        .dark-mode .bg-white,
        .dark-mode .bg-gray-50,
        .dark-mode .bg-white\/80 {
            background-color: #2A3654;
            /* Menggunakan Primary Color untuk kartu */
            color: #E6E8E9;
        }

        /* Navigasi transparan di Dark Mode */
        .dark-mode .bg-white\/90,
        .dark-mode .bg-white\/95 {
            background-color: rgba(42, 54, 84, 0.9);
        }

        .dark-mode .text-gray-500,
        .dark-mode .text-sm {
            color: #C6B18D;
            /* Menggunakan warna aksen emas pucat */
        }

        .dark-mode .text-gray-700 {
            color: #E6E8E9;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="transition-colors duration-500 ease-in-out">

    <header class="bg-white/80 backdrop-blur-md shadow-lg sticky top-0 w-full z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center p-4">
            <a href="index.html" class="flex items-center space-x-4">
                <img src="Zocco Heritage.jpg" alt="Zocco Heritage Logo"
                    class="w-14 md:w-16 transition-all duration-300">
            </a>
            <h1 class="text-3xl md:text-4xl font-bold text-[var(--color-primary)]">Zocco Heritage</h1>
            <nav class="hidden md:flex space-x-8 font-medium text-gray-700">
                <a href="index.html"
                    class="hover:text-[var(--color-accent)] transition-all duration-300 ease-in-out">Beranda</a>
            </nav>
            <button
                class="md:hidden text-gray-800 text-3xl transition-transform duration-300 ease-in-out transform hover:rotate-90"
                id="menu-btn">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
        </div>
        <div id="mobile-menu"
            class="hidden md:hidden bg-white/95 backdrop-blur-md transition-all duration-500 ease-in-out">
            <nav class="flex flex-col space-y-4 p-4 text-gray-800 font-medium">
                <a href="index.html" class="hover:text-[var(--color-accent)] transition-all duration-300">Beranda</a>
            </nav>
        </div>
    </header>

    <nav
        class="sticky top-[72px] md:top-[80px] bg-white/90 backdrop-blur-md shadow-sm z-40 py-3 transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-4 overflow-x-auto scrollbar-hide">
            <ul class="flex justify-center space-x-4 sm:space-x-8 whitespace-nowrap">
                <li><a href="#signature-kopi"
                        class="menu-tab text-sm sm:text-base font-medium text-gray-700 hover:text-[var(--color-accent)] transition-all duration-300 px-3 py-2 border-b-2 border-transparent hover:border-[var(--color-accent)]">Signature
                        Kopi</a></li>
                <li><a href="#kue-warisan"
                        class="menu-tab text-sm sm:text-base font-medium text-gray-700 hover:text-[var(--color-accent)] transition-all duration-300 px-3 py-2 border-b-2 border-transparent hover:border-[var(--color-accent)]">Kue
                        Warisan</a></li>
                <li><a href="#teh-eksklusif"
                        class="menu-tab text-sm sm:text-base font-medium text-gray-700 hover:text-[var(--color-accent)] transition-all duration-300 px-3 py-2 border-b-2 border-transparent hover:border-[var(--color-accent)]">Teh
                        Eksklusif</a>
                </li>
            </ul>
        </div>
    </nav>

    <main class="py-16 transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-4">

            <section id="signature-kopi" class="mb-16">
                <div class="flex items-center space-x-4 mb-8">
                    <h2 class="text-5xl font-extrabold text-[var(--color-primary)]">Signature Kopi</h2>
                    <div class="h-1 w-16 bg-[var(--color-accent)] rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div
                        class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row transform hover:scale-105 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1541167760459-0091d243b781?q=80&w=600&h=400&fit=crop"
                            alt="Royal Espresso Blend" class="w-full md:w-1/2 h-48 md:h-auto object-cover">
                        <div class="p-6 flex-1">
                            <h3 class="font-bold text-xl mb-2 text-gray-900">Royal Espresso Blend
                            </h3>
                            <p class="text-gray-500 text-sm mb-4">Campuran biji premium yang dipanggang lambat, dengan
                                catatan *caramel* dan kakao yang kaya.</p>
                            <span class="text-[var(--color-accent)] font-bold text-lg">Rp 48.000</span>
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row transform hover:scale-105 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1629851720875-f55a13348083?q=80&w=600&h=400&fit=crop"
                            alt="The Golden Cappuccino" class="w-full md:w-1/2 h-48 md:h-auto object-cover">
                        <div class="p-6 flex-1">
                            <h3 class="font-bold text-xl mb-2 text-gray-900">The Golden Cappuccino</h3>
                            <p class="text-gray-500 text-sm mb-4">Espresso royal dengan busa sutra tebal, ditaburi bubuk
                                emas yang dapat dimakan.</p>
                            <span class="text-[var(--color-accent)] font-bold text-lg">Rp 55.000</span>
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row transform hover:scale-105 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1579998132921-274e79391060?q=80&w=600&h=400&fit=crop"
                            alt="Iced Heritage Latte" class="w-full md:w-1/2 h-48 md:h-auto object-cover">
                        <div class="p-6 flex-1">
                            <h3 class="font-bold text-xl mb-2 text-gray-900">Iced Heritage Latte</h3>
                            <p class="text-gray-500 text-sm mb-4">Kopi dingin yang menyegarkan dengan sentuhan sirup
                                *hazelnut* dan susu almond.</p>
                            <span class="text-[var(--color-accent)] font-bold text-lg">Rp 52.000</span>
                        </div>
                    </div>
                </div>
            </section>

            <section id="kue-warisan" class="mb-16">
                <div class="flex items-center space-x-4 mb-8">
                    <h2 class="text-5xl font-extrabold text-[var(--color-primary)]">Kue Warisan</h2>
                    <div class="h-1 w-16 bg-[var(--color-accent)] rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div
                        class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row transform hover:scale-105 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1582234057639-55615d86f7b1?q=80&w=600&h=400&fit=crop"
                            alt="Classic Opera Cake" class="w-full md:w-1/2 h-48 md:h-auto object-cover">
                        <div class="p-6 flex-1">
                            <h3 class="font-bold text-xl mb-2 text-gray-900">Classic Opera Cake</h3>
                            <p class="text-gray-500 text-sm mb-4">Kue almond Prancis berlapis krim kopi dan cokelat
                                ganache. Sebuah warisan klasik.</p>
                            <span class="text-[var(--color-accent)] font-bold text-lg">Rp 75.000</span>
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row transform hover:scale-105 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1549487771-88481ff23b9d?q=80&w=600&h=400&fit=crop"
                            alt="Lemon Lavender Scone" class="w-full md:w-1/2 h-48 md:h-auto object-cover">
                        <div class="p-6 flex-1">
                            <h3 class="font-bold text-xl mb-2 text-gray-900">Lemon Lavender Scone</h3>
                            <p class="text-gray-500 text-sm mb-4">Scone panggang yang lembut dengan aroma lemon dan
                                sentuhan bunga lavender.</p>
                            <span class="text-[var(--color-accent)] font-bold text-lg">Rp 42.000</span>
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row transform hover:scale-105 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1585250007205-d143c7b8e562?q=80&w=600&h=400&fit=crop"
                            alt="Tarte Tatin Apel" class="w-full md:w-1/2 h-48 md:h-auto object-cover">
                        <div class="p-6 flex-1">
                            <h3 class="font-bold text-xl mb-2 text-gray-900">Tarte Tatin Apel</h3>
                            <p class="text-gray-500 text-sm mb-4">Kue apel terbalik Prancis dengan karamel tua dan
                                *puff
                                pastry* renyah.</p>
                            <span class="text-[var(--color-accent)] font-bold text-lg">Rp 68.000</span>
                        </div>
                    </div>
                </div>
            </section>

            <section id="teh-eksklusif" class="mb-16">
                <div class="flex items-center space-x-4 mb-8">
                    <h2 class="text-5xl font-extrabold text-[var(--color-primary)]">Teh Eksklusif</h2>
                    <div class="h-1 w-16 bg-[var(--color-accent)] rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div
                        class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row transform hover:scale-105 transition-transform duration-300">
                        <img src="https://via.placeholder.com/600x400.png?text=Royal+Earl+Grey" alt="Royal Earl Grey"
                            class="w-full md:w-1/2 h-48 md:h-auto object-cover">
                        <div class="p-6 flex-1">
                            <h3 class="font-bold text-xl mb-2 text-gray-900">Royal Earl Grey</h3>
                            <p class="text-gray-500 text-sm mb-4">Teh hitam Ceylon dengan Bergamot premium, disajikan
                                dengan irisan lemon.</p>
                            <span class="text-[var(--color-accent)] font-bold text-lg">Rp 40.000</span>
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row transform hover:scale-105 transition-transform duration-300">
                        <img src="https://via.placeholder.com/600x400.png?text=White+Peony" alt="White Peony"
                            class="w-full md:w-1/2 h-48 md:h-auto object-cover">
                        <div class="p-6 flex-1">
                            <h3 class="font-bold text-xl mb-2 text-gray-900">White Peony (Bai Mu Dan)</h3>
                            <p class="text-gray-500 text-sm mb-4">Teh putih langka dengan rasa manis lembut alami,
                                aroma
                                bunga yang halus.</p>
                            <span class="text-[var(--color-accent)] font-bold text-lg">Rp 65.000</span>
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row transform hover:scale-105 transition-transform duration-300">
                        <img src="https://via.placeholder.com/600x400.png?text=Moroccan+Mint" alt="Moroccan Mint"
                            class="w-full md:w-1/2 h-48 md:h-auto object-cover">
                        <div class="p-6 flex-1">
                            <h3 class="font-bold text-xl mb-2 text-gray-900">Moroccan Mint</h3>
                            <p class="text-gray-500 text-sm mb-4">Teh hijau yang dicampur dengan daun mint segar dan
                                gula
                                (opsional).</p>
                            <span class="text-[var(--color-accent)] font-bold text-lg">Rp 38.000</span>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </main>

    <button id="theme-toggle"
        class="fixed bottom-6 right-6 p-4 rounded-full bg-[var(--color-accent)] text-white shadow-lg z-50 transition-transform duration-300 ease-in-out hover:scale-110">
        <svg id="moon-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="feather feather-moon">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
        </svg>
        <svg id="sun-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="feather feather-sun hidden">
            <circle cx="12" cy="12" r="5"></circle>
            <line x1="12" y1="1" x2="12" y2="3"></line>
            <line x1="12" y1="21" x2="12" y2="23"></line>
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
            <line x1="1" y1="12" x2="3" y2="12"></line>
            <line x1="21" y1="12" x2="23" y2="12"></line>
            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
        </svg>
    </button>

    <script>
        // Mobile Menu Toggle (Tetap sama)
        const btn = document.getElementById('menu-btn');
        const menu = document.getElementById('mobile-menu');
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        // Toggle Dark Mode (Diadaptasi untuk Zocco Heritage)
        const themeToggle = document.getElementById('theme-toggle');
        const body = document.body;
        const moonIcon = document.getElementById('moon-icon');
        const sunIcon = document.getElementById('sun-icon');

        const toggleIcon = () => {
            if (body.classList.contains('dark-mode')) {
                moonIcon.classList.add('hidden');
                sunIcon.classList.remove('hidden');
            } else {
                moonIcon.classList.remove('hidden');
                sunIcon.classList.add('hidden');
            }
        };

        const toggleTheme = () => {
            if (body.classList.contains('dark-mode')) {
                body.classList.remove('dark-mode');
                localStorage.setItem('theme', 'light');
            } else {
                body.classList.add('dark-mode');
                localStorage.setItem('theme', 'dark');
            }
            toggleIcon();
        };

        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            body.classList.add('dark-mode');
        }
        toggleIcon();

        themeToggle.addEventListener('click', toggleTheme);


        // Garis Bawah Navigasi Mengikuti Scroll (Tetap sama)
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('.menu-tab');

        const updateActiveLink = () => {
            let current = '';

            const headerHeight = document.querySelector('header').offsetHeight;
            const navHeight = document.querySelector('nav').offsetHeight;
            const offset = headerHeight + navHeight + 20;

            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                if (pageYOffset >= sectionTop - offset) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('border-[var(--color-accent)]');
                link.classList.add('border-transparent');
                if (link.getAttribute('href').includes(current)) {
                    link.classList.remove('border-transparent');
                    // Menggunakan warna aksen Zocco Heritage
                    link.classList.add('border-[var(--color-accent)]');
                }
            });
        };

        window.addEventListener('scroll', updateActiveLink);
        window.addEventListener('load', updateActiveLink);
    </script>
</body>

</html>
