<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Madbaker - Menu Unik</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Tangerine:wght@400;700&display=swap"
        rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            /* Warna Madbaker Asli (TIDAK BERUBAH) */
            --color-primary: #8B4513;
            /* Cokelat Tua Hangat */
            --color-secondary: #FFDAB9;
            /* Peach Pucat (Warna Latar) */
            --color-accent: #2F4F4F;
            /* Dark Slate Gray (Warna Aksen Hover/Garis) */
            --color-text: #333333;
            /* Abu-abu Gelap */
        }

        body {
            /* Menggunakan font Montserrat */
            font-family: 'Montserrat', sans-serif;
            color: var(--color-text);
            background-color: var(--color-secondary);
            transition: background-color 0.5s, color 0.5s;
        }

        h1,
        h2 {
            /* Menggunakan font Tangerine untuk Judul Utama (Memberikan kesan eksentrik dan unik sesuai brand) */
            font-family: 'Tangerine', serif;
            font-weight: 700;
            /* Dibuat tebal agar terbaca */
        }

        h3 {
            /* Menggunakan font Montserrat untuk Sub-Judul Item Menu */
            font-family: 'Montserrat', sans-serif;
        }

        /* Mengubah ukuran h2 agar Tangerine yang lebih tipis tetap terbaca */
        h2 {
            font-size: 3.5rem;
            /* Lebih besar dari sebelumnya 4xl */
        }

        /* --- Dark Mode Styles (Tetap sama) --- */
        .dark-mode {
            background-color: #1a202c;
            color: #e2e8f0;
        }

        .dark-mode .text-gray-900,
        .dark-mode .text-gray-800 {
            color: #e2e8f0;
        }

        .dark-mode .bg-white,
        .dark-mode .bg-gray-50,
        .dark-mode .bg-white\/80 {
            background-color: #2d3748;
            color: #e2e8f0;
        }

        .dark-mode .bg-white\/90,
        .dark-mode .bg-white\/95 {
            background-color: rgba(45, 55, 72, 0.9);
        }

        .dark-mode .shadow-lg {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2), 0 2px 4px -1px rgba(0, 0, 0, 0.1);
        }

        .dark-mode .text-gray-500 {
            color: #a0aec0;
        }

        .dark-mode .text-gray-700 {
            color: #cbd5e0;
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
                <img src="logomadbaker.png" alt="Madbaker Logo" class="w-14 md:w-16 transition-all duration-300">
            </a>
            <h1 class="text-4xl md:text-5xl font-bold text-[var(--color-primary)]">Madbaker Menu</h1>
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
                <li><a href="#kue-unik"
                        class="menu-tab text-sm sm:text-base font-medium text-gray-700 hover:text-[var(--color-accent)] transition-all duration-300 px-3 py-2 border-b-2 border-transparent hover:border-[var(--color-accent)]">Kue-Kue
                        Eksentrik</a></li>
                <li><a href="#roti-istimewa"
                        class="menu-tab text-sm sm:text-base font-medium text-gray-700 hover:text-[var(--color-accent)] transition-all duration-300 px-3 py-2 border-b-2 border-transparent hover:border-[var(--color-accent)]">Roti
                        Istimewa</a></li>
                <li><a href="#minuman"
                        class="menu-tab text-sm sm:text-base font-medium text-gray-700 hover:text-[var(--color-accent)] transition-all duration-300 px-3 py-2 border-b-2 border-transparent hover:border-[var(--color-accent)]">Minuman</a>
                </li>
            </ul>
        </div>
    </nav>

    <main class="py-16 transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-4">

            <section id="kue-unik" class="mb-16">
                <div class="flex items-center space-x-4 mb-8">
                    <h2 class="text-6xl font-extrabold text-[var(--color-primary)]">Kue-Kue Eksentrik</h2>
                    <div class="h-1 w-16 bg-[var(--color-accent)] rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div
                        class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row transform hover:scale-105 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1578985545069-b57f20258079?q=80&w=600&h=400&fit=crop"
                            alt="Signature Mad Chocolate Cake" class="w-full md:w-1/2 h-48 md:h-auto object-cover">
                        <div class="p-6 flex-1">
                            <h3 class="font-bold text-xl mb-2 text-gray-900">Signature Mad Chocolate Cake
                            </h3>
                            <p class="text-gray-500 text-sm mb-4">Kue cokelat panggang dengan lelehan cokelat di tengah
                                yang luar biasa. Ciri khas Madbaker.</p>
                            <span class="text-[var(--color-accent)] font-bold text-lg">Rp 65.000</span>
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row transform hover:scale-105 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1628172900227-8a62f8313e9a?q=80&w=600&h=400&fit=crop"
                            alt="The Golden Cheesecake" class="w-full md:w-1/2 h-48 md:h-auto object-cover">
                        <div class="p-6 flex-1">
                            <h3 class="font-bold text-xl mb-2 text-gray-900">The Golden Cheesecake</h3>
                            <p class="text-gray-500 text-sm mb-4">Kue keju lembut dengan dasar biskuit yang renyah dan
                                topping karamel premium.</p>
                            <span class="text-[var(--color-accent)] font-bold text-lg">Rp 72.000</span>
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row transform hover:scale-105 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1587393437295-d224213d2a7c?q=80&w=600&h=400&fit=crop"
                            alt="Black Forest Lava" class="w-full md:w-1/2 h-48 md:h-auto object-cover">
                        <div class="p-6 flex-1">
                            <h3 class="font-bold text-xl mb-2 text-gray-900">Black Forest Lava</h3>
                            <p class="text-gray-500 text-sm mb-4">Kue bolu cokelat dengan krim segar, ceri, dan cokelat
                                pahit. Disajikan hangat.</p>
                            <span class="text-[var(--color-accent)] font-bold text-lg">Rp 58.000</span>
                        </div>
                    </div>
                </div>
            </section>

            <section id="roti-istimewa" class="mb-16">
                <div class="flex items-center space-x-4 mb-8">
                    <h2 class="text-6xl font-extrabold text-[var(--color-primary)]">Roti Istimewa</h2>
                    <div class="h-1 w-16 bg-[var(--color-accent)] rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div
                        class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row transform hover:scale-105 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1547844111-a832a24340d8?q=80&w=600&h=400&fit=crop"
                            alt="Croissant Almond" class="w-full md:w-1/2 h-48 md:h-auto object-cover">
                        <div class="p-6 flex-1">
                            <h3 class="font-bold text-xl mb-2 text-gray-900">Croissant Almond</h3>
                            <p class="text-gray-500 text-sm mb-4">Croissant renyah berlapis dengan isian krim almond
                                dan taburan serpihan almond.</p>
                            <span class="text-[var(--color-accent)] font-bold text-lg">Rp 35.000</span>
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row transform hover:scale-105 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1627961209372-f5c711019672?q=80&w=600&h=400&fit=crop"
                            alt="Pain Au Chocolat" class="w-full md:w-1/2 h-48 md:h-auto object-cover">
                        <div class="p-6 flex-1">
                            <h3 class="font-bold text-xl mb-2 text-gray-900">Pain Au Chocolat</h3>
                            <p class="text-gray-500 text-sm mb-4">Roti Prancis klasik yang lembut dengan batang cokelat
                                semi-manis di dalamnya.</p>
                            <span class="text-[var(--color-accent)] font-bold text-lg">Rp 30.000</span>
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row transform hover:scale-105 transition-transform duration-300">
                        <img src="https://images.unsplash.com/photo-1626359336100-3027b6863d08?q=80&w=600&h=400&fit=crop"
                            alt="Red Velvet Bomboloni" class="w-full md:w-1/2 h-48 md:h-auto object-cover">
                        <div class="p-6 flex-1">
                            <h3 class="font-bold text-xl mb-2 text-gray-900">Red Velvet Bomboloni</h3>
                            <p class="text-gray-500 text-sm mb-4">Donat Italia tanpa lubang dengan krim keju *red
                                velvet*
                                yang kaya dan lumer.</p>
                            <span class="text-[var(--color-accent)] font-bold text-lg">Rp 28.000</span>
                        </div>
                    </div>
                </div>
            </section>

            <section id="minuman" class="mb-16">
                <div class="flex items-center space-x-4 mb-8">
                    <h2 class="text-6xl font-extrabold text-[var(--color-primary)]">Minuman</h2>
                    <div class="h-1 w-16 bg-[var(--color-accent)] rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div
                        class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row transform hover:scale-105 transition-transform duration-300">
                        <img src="https://via.placeholder.com/600x400.png?text=Espresso" alt="Espresso"
                            class="w-full md:w-1/2 h-48 md:h-auto object-cover">
                        <div class="p-6 flex-1">
                            <h3 class="font-bold text-xl mb-2 text-gray-900">Espresso</h3>
                            <p class="text-gray-500 text-sm mb-4">Bidikan kopi pekat yang intens, biji panggang Dark
                                Baker
                                Blend.</p>
                            <span class="text-[var(--color-accent)] font-bold text-lg">Rp 25.000</span>
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row transform hover:scale-105 transition-transform duration-300">
                        <img src="https://via.placeholder.com/600x400.png?text=Chocolate+Latte" alt="Chocolate Latte"
                            class="w-full md:w-1/2 h-48 md:h-auto object-cover">
                        <div class="p-6 flex-1">
                            <h3 class="font-bold text-xl mb-2 text-gray-900">Chocolate Latte</h3>
                            <p class="text-gray-500 text-sm mb-4">Paduan espresso dan cokelat susu premium, disajikan
                                panas atau dingin.</p>
                            <span class="text-[var(--color-accent)] font-bold text-lg">Rp 35.000</span>
                        </div>
                    </div>
                    <div
                        class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col md:flex-row transform hover:scale-105 transition-transform duration-300">
                        <img src="https://via.placeholder.com/600x400.png?text=Artisanal+Tea" alt="Artisanal Tea"
                            class="w-full md:w-1/2 h-48 md:h-auto object-cover">
                        <div class="p-6 flex-1">
                            <h3 class="font-bold text-xl mb-2 text-gray-900">Artisanal Tea</h3>
                            <p class="text-gray-500 text-sm mb-4">Pilihan teh premium dari petani lokal, seperti Earl
                                Grey
                                atau Sencha.</p>
                            <span class="text-[var(--color-accent)] font-bold text-lg">Rp 22.000</span>
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

        // Toggle Dark Mode (Tetap sama)
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
                    link.classList.add('border-[var(--color-accent)]');
                }
            });
        };

        window.addEventListener('scroll', updateActiveLink);
        window.addEventListener('load', updateActiveLink);
    </script>
</body>

</html>
