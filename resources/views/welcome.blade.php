<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zocco Coffee & Roastery</title>
    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- AlpineJS -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- ScrollReveal -->
    <script src="https://unpkg.com/scrollreveal"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
        }

        @keyframes pulse-slow {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.2;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.3;
            }
        }

        .animate-pulse-slow {
            animation: pulse-slow 8s ease-in-out infinite;
        }
    </style>
</head>

<body class="font-sans bg-gray-50 text-gray-900">

    <!-- Header -->
    <header class="bg-black/60 backdrop-blur-md shadow-md fixed w-full z-50 top-0">
        <div class="max-w-7xl mx-auto flex justify-between items-center p-4">

            <!-- LOGO -->
            <div class="flex items-center space-x-4">
                <img src="logozocco.png" alt="Zocco Coffee Logo" class="w-12 md:w-14">
                <img src="heritagelogo.png" alt="Heritage Logo" class="w-14 md:w-16">
                <img src="madbakerlogo.png" alt="Madbaker Logo" class="w-14 md:w-16">
            </div>

            <!-- NAVIGATION -->
            <nav class="hidden md:flex space-x-8 font-medium text-white">
                <a href="#menu" class="hover:text-yellow-500 transition">Menu</a>
                <a href="#about" class="hover:text-yellow-500 transition">About</a>
                <a href="#gallery" class="hover:text-yellow-500 transition">Gallery</a>
                <a href="#contact" class="hover:text-yellow-500 transition">Contact</a>
            </nav>

            <!-- MOBILE MENU BUTTON -->
            <button class="md:hidden text-yellow-500 text-3xl" id="menu-btn">☰</button>
        </div>

        <!-- MOBILE MENU DROPDOWN -->
        <div id="mobile-menu" class="hidden md:hidden bg-black/90 backdrop-blur-md">
            <nav class="flex flex-col space-y-4 p-4 text-white font-medium">
                <a href="#menu" class="hover:text-yellow-500 transition">Menu</a>
                <a href="#about" class="hover:text-yellow-500 transition">About</a>
                <a href="#gallery" class="hover:text-yellow-500 transition">Gallery</a>
                <a href="#contact" class="hover:text-yellow-500 transition">Contact</a>
            </nav>
        </div>
    </header>

    <!-- Hero Carousel -->
    <section x-data="{
        active: 0,
        slides: [
            'https://images.unsplash.com/photo-1511920170033-f8396924c348?auto=format&fit=crop&w=1950&q=80',
            'https://images.unsplash.com/photo-1541167760496-1628856ab772?auto=format&fit=crop&w=1950&q=80',
            'https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=1950&q=80'
        ]
    }" x-init="setInterval(() => { active = (active + 1) % slides.length }, 4000)" class="relative h-screen overflow-hidden mt-16">

        <!-- Slides -->
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="active===index" x-transition.opacity.duration.1000ms
                class="absolute inset-0 bg-cover bg-center" :style="'background-image: url(' + slide + ')'">
                <div
                    class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/30 to-black/70 
                            flex flex-col justify-center items-center text-center text-white px-4">
                    <h1 class="text-4xl md:text-6xl font-bold mb-4 drop-shadow-lg tracking-wide">
                        Nikmati Setiap Seduhan
                    </h1>
                    <p class="text-lg md:text-2xl mb-6 drop-shadow-md">
                        Kopi spesial & vibes cozy di Zocco Coffee
                    </p>
                    <a href="#menu"
                        class="bg-yellow-600 hover:bg-yellow-700 px-6 py-3 rounded-full 
                               text-white font-semibold shadow-lg transition transform hover:scale-105">
                        Lihat Menu
                    </a>
                </div>
            </div>
        </template>

        <!-- Carousel Navigation -->
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 flex space-x-4">
            <button @click="active=(active-1+slides.length)%slides.length"
                class="bg-white/70 hover:bg-white text-gray-800 px-4 py-2 rounded-full shadow-lg transition">❮</button>
            <button @click="active=(active+1)%slides.length"
                class="bg-white/70 hover:bg-white text-gray-800 px-4 py-2 rounded-full shadow-lg transition">❯</button>
        </div>
    </section>

    <!-- Menu Section -->
    <section id="menu" class="py-24 bg-gray-50 relative">
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-gray-50 via-gray-100 to-gray-200"></div>
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-5xl font-extrabold mb-12 text-gray-900 tracking-tight">Menu Favorit Kami</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                <!-- Card Example -->
                <div class="bg-white rounded-3xl shadow-lg overflow-hidden relative group hover:shadow-2xl transition">
                    <span
                        class="absolute top-0 left-0 bg-yellow-500 text-white px-3 py-1 rounded-tr-2xl font-bold">Rp25.000</span>
                    <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=800&q=80"
                        class="w-full h-48 object-cover transition-transform group-hover:scale-105">
                    <div class="p-4 text-left">
                        <h3 class="font-bold text-lg mb-2">Espresso</h3>
                        <p class="text-gray-500 text-sm mb-3">100% Arabica, roasted medium, creamy aroma</p>
                        <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#menu1">Detail</button>
                    </div>
                </div>
                <!-- Modal Example -->
                <div class="modal fade" id="menu1" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content rounded-3xl">
                            <div class="modal-header border-0">
                                <h5 class="modal-title">Espresso</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>Komposisi: 100% Arabica, roasted medium, creamy aroma</p>
                                <p>Sajian: Hot / Iced</p>
                                <p class="fw-bold text-warning">Harga: Rp25.000</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Example -->
                <div class="bg-white rounded-3xl shadow-lg overflow-hidden relative group hover:shadow-2xl transition">
                    <span
                        class="absolute top-0 left-0 bg-yellow-500 text-white px-3 py-1 rounded-tr-2xl font-bold">Rp25.000</span>
                    <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=800&q=80"
                        class="w-full h-48 object-cover transition-transform group-hover:scale-105">
                    <div class="p-4 text-left">
                        <h3 class="font-bold text-lg mb-2">Espresso</h3>
                        <p class="text-gray-500 text-sm mb-3">100% Arabica, roasted medium, creamy aroma</p>
                        <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#menu1">Detail</button>
                    </div>
                </div>
                <!-- Modal Example -->
                <div class="modal fade" id="menu1" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content rounded-3xl">
                            <div class="modal-header border-0">
                                <h5 class="modal-title">Espresso</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>Komposisi: 100% Arabica, roasted medium, creamy aroma</p>
                                <p>Sajian: Hot / Iced</p>
                                <p class="fw-bold text-warning">Harga: Rp25.000</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Example -->
                <div class="bg-white rounded-3xl shadow-lg overflow-hidden relative group hover:shadow-2xl transition">
                    <span
                        class="absolute top-0 left-0 bg-yellow-500 text-white px-3 py-1 rounded-tr-2xl font-bold">Rp25.000</span>
                    <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=800&q=80"
                        class="w-full h-48 object-cover transition-transform group-hover:scale-105">
                    <div class="p-4 text-left">
                        <h3 class="font-bold text-lg mb-2">Espresso</h3>
                        <p class="text-gray-500 text-sm mb-3">100% Arabica, roasted medium, creamy aroma</p>
                        <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#menu1">Detail</button>
                    </div>
                </div>
                <!-- Modal Example -->
                <div class="modal fade" id="menu1" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content rounded-3xl">
                            <div class="modal-header border-0">
                                <h5 class="modal-title">Espresso</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>Komposisi: 100% Arabica, roasted medium, creamy aroma</p>
                                <p>Sajian: Hot / Iced</p>
                                <p class="fw-bold text-warning">Harga: Rp25.000</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Example -->
                <div class="bg-white rounded-3xl shadow-lg overflow-hidden relative group hover:shadow-2xl transition">
                    <span
                        class="absolute top-0 left-0 bg-yellow-500 text-white px-3 py-1 rounded-tr-2xl font-bold">Rp25.000</span>
                    <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=800&q=80"
                        class="w-full h-48 object-cover transition-transform group-hover:scale-105">
                    <div class="p-4 text-left">
                        <h3 class="font-bold text-lg mb-2">Espresso</h3>
                        <p class="text-gray-500 text-sm mb-3">100% Arabica, roasted medium, creamy aroma</p>
                        <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#menu1">Detail</button>
                    </div>
                </div>
                <!-- Modal Example -->
                <div class="modal fade" id="menu1" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content rounded-3xl">
                            <div class="modal-header border-0">
                                <h5 class="modal-title">Espresso</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p>Komposisi: 100% Arabica, roasted medium, creamy aroma</p>
                                <p>Sajian: Hot / Iced</p>
                                <p class="fw-bold text-warning">Harga: Rp25.000</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Duplicate cards sesuai kebutuhan -->
            </div>
        </div>
        <div style="margin-left: 1100px; margin-top: 20px">
            <a href=""
                class="inline-block bg-yellow-600 text-white font-semibold px-5 py-2 rounded-full shadow-lg
              hover:bg-yellow-700 hover:scale-105 transition transform duration-300">Detail
                Menu</a>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-24 bg-white">
        <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row items-center gap-12">
            <img src="https://images.unsplash.com/photo-1511920170033-f8396924c348?auto=format&fit=crop&w=800&q=80"
                class="w-full md:w-1/2 rounded-xl shadow-lg transform hover:scale-105 transition duration-500">
            <div class="md:w-1/2 text-center md:text-left">
                <h2 class="text-3xl font-bold mb-4">Tentang Zocco Coffee</h2>
                <p class="mb-4 text-gray-700 leading-relaxed">
                    Zocco Coffee hadir untuk memberikan <span class="text-yellow-600 font-semibold">pengalaman kopi
                        terbaik</span> dengan roasted beans <span class="font-semibold">berkualitas tinggi</span>.
                    Suasana <span class="italic">cozy</span>, vibes modern, dan pelayanan ramah membuat setiap
                    kunjungan
                    terasa spesial.
                </p>
                <a href="#contact"
                    class="bg-yellow-600 hover:bg-yellow-700 px-6 py-3 rounded-full text-white font-semibold shadow-lg transition transform hover:scale-105">Hubungi
                    Kami</a>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="py-24 relative overflow-hidden">
        <!-- Background Elegan -->
        <div class="absolute inset-0 -z-10">
            <!-- Gradient -->
            <div class="absolute inset-0 bg-gradient-to-br from-gray-50 via-gray-100 to-gray-200"></div>
            <!-- Pattern Halus -->
            <div
                class="absolute inset-0 bg-[url('https://www.toptal.com/designers/subtlepatterns/patterns/dot-grid.png')] bg-repeat opacity-10">
            </div>
            <!-- Bokeh/Blur circles -->
            <div
                class="absolute -top-16 -left-16 w-96 h-96 bg-yellow-300 rounded-full opacity-20 blur-3xl animate-pulse-slow">
            </div>
            <div
                class="absolute -bottom-16 -right-16 w-96 h-96 bg-yellow-400 rounded-full opacity-20 blur-3xl animate-pulse-slow">
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-5xl font-extrabold mb-16 text-gray-900 tracking-tight">Galeri Zocco Coffee</h2>
            <!-- Masonry Grid -->
            <div class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-6 space-y-6" x-data="{
                images: [
                    { src: '1.png', h: 'h-48' },
                    { src: '2.png', h: 'h-64' },
                    { src: '3.png', h: 'h-56' },
                    { src: '4.png', h: 'h-48' },
                    { src: '5.png', h: 'h-64' },
                    { src: '6.png', h: 'h-56' },
                    { src: '7.png', h: 'h-48' },
                    { src: '8.png', h: 'h-64' }
                ]
            }">
                <template x-for="img in images" :key="img.src">
                    <div
                        class="relative group break-inside-avoid overflow-hidden rounded-2xl shadow-md hover:shadow-xl transition duration-500">
                        <img :src="img.src"
                            :class="img.h +
                                ' w-full object-cover transform transition duration-700 ease-out group-hover:scale-110'">
                        <div
                            class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition duration-500">
                            <span class="text-white text-lg font-semibold">Zocco Coffee</span>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-12">Hubungi Kami</h2>
            <p class="mb-6 text-gray-700">Alamat: Jl. Kopi No.123, Malang</p>
            <p class="mb-6 text-gray-700">WA: +62 812 3456 7890</p>
            <p class="mb-10 text-gray-700">Instagram: @zoccocoffee</p>
            <form class="flex flex-col md:flex-row gap-4 justify-center">
                <input type="text" placeholder="Nama"
                    class="p-3 border rounded-md w-full md:w-1/3 focus:outline-none focus:ring-2 focus:ring-yellow-600">
                <input type="email" placeholder="Email"
                    class="p-3 border rounded-md w-full md:w-1/3 focus:outline-none focus:ring-2 focus:ring-yellow-600">
                <button type="submit"
                    class="bg-yellow-600 hover:bg-yellow-700 px-6 py-3 rounded-full text-white font-semibold shadow-lg transition transform hover:scale-105">Kirim</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8 border-t border-gray-700">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-400">&copy; 2025 Zocco Coffee. All rights reserved.</p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a href="#" class="hover:text-yellow-500 transition">Instagram</a>
                <a href="#" class="hover:text-yellow-500 transition">Facebook</a>
                <a href="#" class="hover:text-yellow-500 transition">TikTok</a>
            </div>
        </div>
    </footer>

    <!-- JS Menu Toggle & ScrollReveal -->
    <script>
        const btn = document.getElementById('menu-btn');
        const menu = document.getElementById('mobile-menu');
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        ScrollReveal().reveal('section h2', {
            delay: 200,
            distance: '50px',
            origin: 'bottom',
            duration: 800,
            reset: false
        });
        ScrollReveal().reveal('.grid > div, .grid > img, section p, section img', {
            delay: 300,
            distance: '30px',
            origin: 'bottom',
            duration: 800,
            reset: false,
            interval: 150
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
