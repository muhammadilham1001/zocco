<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zocco</title>
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,700&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        montserrat: ['Montserrat', 'sans-serif'],
                        longa: ['Longa Iberica', 'serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <style>
        @font-face {
            font-family: 'Longa Iberica';
            /* Hapus spasi di nama file agar sesuai dengan nama file baru Anda */
            src: url("{{ asset('fonts/LongaIberica.otf') }}") format('opentype'),
                url("{{ asset('fonts/LongaIberica.ttf') }}") format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        :root {
            --color-primary: #ca8a04;
            /* Yellow Zocco */
            --color-dark: #020617;
            /* Slate Dark */
            --color-card: #0f172a;
            /* Slate 900 */
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: #e2e8f0;
            background-color: var(--color-dark);
            transition: background-color 0.5s ease, color 0.5s ease;
        }

        h2,
        h3 {
            font-family: 'Playfair Display', serif;
        }

        html {
            scroll-behavior: smooth;
        }

        .glass-effect {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .parallax-bg {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        @keyframes pulse-slow {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.2;
            }
        }

        .animate-pulse-slow {
            animation: pulse-slow 8s ease-in-out infinite;
        }

        /* Override Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #020617;
        }

        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #ca8a04;
        }

        .horizontal-scroll-container {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            scroll-snap-type: x mandatory;
        }

        .horizontal-scroll-container::-webkit-scrollbar {
            display: none;
        }

        .horizontal-scroll-container>div {
            scroll-snap-align: start;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body x-data="{ isModalOpen: false, isMobileMenuOpen: false, userMenu: false }" class="bg-slate-950 text-gray-200 transition-colors duration-500 ease-in-out">

    {{-- Header dengan Glass Effect --}}
    <header
        class="glass-effect shadow-2xl fixed w-full z-50 top-0 transition-all duration-300 ease-in-out border-b border-white/5">
        <div class="max-w-7xl mx-auto flex justify-between items-center p-4">
            <div class="flex items-center space-x-4">
                @foreach ($outlets->whereNotNull('logo')->take(3) as $outlet)
                    <img src="{{ asset('storage/' . $outlet->logo) }}" alt="{{ $outlet->name }}"
                        class="w-12 md:w-16 h-12 md:h-14 object-contain brightness-110" title="{{ $outlet->name }}">
                @endforeach

                @if ($outlets->whereNotNull('logo')->count() == 0)
                    <div
                        class="w-10 h-10 bg-yellow-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg rotate-3">
                        Z</div>
                @endif
            </div>

            <nav class="hidden md:flex items-center space-x-8 font-medium text-gray-300">
                <a href="#outlets" class="hover:text-yellow-500 transition-all">Outlets</a>
                <a href="#produk" class="hover:text-yellow-500 transition-all">Produk</a>
                <a href="#about" class="hover:text-yellow-500 transition-all">About</a>
                <a href="#gallery" class="hover:text-yellow-500 transition-all">Gallery</a>
                <a href="#contact" class="hover:text-yellow-500 transition-all">Contact</a>

                @guest
                    <a href="{{ route('login') }}"
                        class="ml-4 px-6 py-2 bg-yellow-600 text-white rounded-full hover:bg-yellow-700 transition-all shadow-lg transform hover:scale-105">Login</a>
                @else
                    <div class="relative ml-4">
                        <button @click="userMenu = !userMenu"
                            class="flex items-center space-x-2 px-3 py-1.5 bg-slate-800 rounded-full border border-white/10 hover:border-yellow-600/50 transition-all">
                            <div
                                class="w-8 h-8 bg-yellow-600 rounded-full flex items-center justify-center text-white font-bold text-xs shadow-inner">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="text-sm font-semibold text-white">{{ Auth::user()->name }}</span>
                        </button>

                        <div x-show="userMenu" @click.outside="userMenu = false" x-cloak
                            class="absolute right-0 mt-2 w-48 bg-slate-900 rounded-xl shadow-2xl border border-white/10 overflow-hidden">
                            <button @click="isModalOpen = true; userMenu = false"
                                class="w-full text-left block px-4 py-3 text-sm text-gray-300 hover:bg-slate-800 hover:text-yellow-500 transition-colors">
                                Edit Profil</button>
                            <a href="{{ route('user.reservation') }}"
                                class="w-full text-left block px-4 py-3 text-sm text-gray-300 hover:bg-slate-800 hover:text-yellow-500 transition-colors">
                                Reservation</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-3 text-sm text-red-400 hover:bg-red-900/20 border-t border-white/5">
                                    Logout</button>
                            </form>
                        </div>
                    </div>
                @endguest
            </nav>

            <button class="md:hidden text-gray-300 text-3xl" @click="isMobileMenuOpen = !isMobileMenuOpen">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>

        <div x-show="isMobileMenuOpen" @click.outside="isMobileMenuOpen = false"
            class="md:hidden bg-slate-900 border-t border-white/10 p-4 space-y-4 shadow-xl" x-cloak>
            <a href="#outlets" class="block text-gray-300 font-medium">Outlets</a>
            <a href="#produk" class="block text-gray-300 font-medium">Produk</a>
            <a href="#about" class="block text-gray-300 font-medium">About</a>
            <a href="#gallery" class="block text-gray-300 font-medium">Gallery</a>
            <a href="#contact" class="block text-gray-300 font-medium">Contact</a>
            <hr class="border-white/5">
            @guest
                <a href="{{ route('login') }}"
                    class="block w-full text-center px-6 py-3 bg-yellow-600 text-white rounded-xl font-bold">Login</a>
            @else
                <div class="space-y-3">
                    <div class="flex items-center space-x-3 p-3 bg-slate-800 rounded-xl">
                        <div
                            class="w-10 h-10 bg-yellow-600 rounded-full flex items-center justify-center text-white font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-white">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-2">
                        <button @click="isModalOpen = true; isMobileMenuOpen = false"
                            class="text-left px-4 py-2 text-sm text-gray-300 hover:text-yellow-500">Edit Profil</button>
                        <a href="{{ route('user.reservation') }}"
                            class="text-left px-4 py-2 text-sm text-gray-300 hover:text-yellow-500">Reservasi</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-red-400 font-bold">Logout</button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </header>

    {{-- Modal Edit Profil --}}
    <div x-show="isModalOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[9999] overflow-y-auto flex items-center justify-center p-4" x-cloak>
        <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-md" @click="isModalOpen = false"></div>
        <div
            class="relative bg-slate-900 w-full max-w-lg rounded-[2.5rem] shadow-2xl overflow-hidden border border-white/10">
            <div class="h-2 bg-yellow-600"></div>
            <div class="p-8 md:p-10">
                <button @click="isModalOpen = false"
                    class="absolute top-6 right-6 p-2 rounded-full bg-slate-800 text-gray-400 hover:text-red-500 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div class="mb-8">
                    <h3 class="text-3xl font-serif italic text-white mb-2">Pengaturan Profil</h3>
                    <p class="text-gray-400 text-xs uppercase tracking-widest">Update identitas anda</p>
                </div>
                <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf @method('PUT')
                    <div class="space-y-2">
                        <label class="block text-[10px] font-bold text-yellow-600 uppercase tracking-widest ml-1">Nama
                            Lengkap</label>
                        <input type="text" name="name" value="{{ Auth::check() ? Auth::user()->name : '' }}"
                            required
                            class="w-full px-4 py-4 rounded-2xl bg-slate-950 border border-white/10 text-white focus:border-yellow-600 outline-none transition-all">
                    </div>
                    <div class="space-y-2">
                        <label
                            class="block text-[10px] font-bold text-yellow-600 uppercase tracking-widest ml-1">Alamat
                            Email</label>
                        <input type="email" name="email" value="{{ Auth::check() ? Auth::user()->email : '' }}"
                            required
                            class="w-full px-4 py-4 rounded-2xl bg-slate-950 border border-white/10 text-white focus:border-yellow-600 outline-none transition-all">
                    </div>
                    <div class="pt-6 flex flex-col sm:flex-row gap-4">
                        <button type="submit"
                            class="flex-1 py-4 bg-yellow-600 hover:bg-yellow-700 text-white font-bold rounded-2xl shadow-lg transition-all transform hover:-translate-y-1">Simpan</button>
                        <button type="button" @click="isModalOpen = false"
                            class="flex-1 py-4 bg-slate-800 text-gray-300 font-bold rounded-2xl border border-white/5">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Hero Section --}}
    <section x-data="{
        active: 0,
        slides: [
            'https://images.unsplash.com/photo-1541167760496-1628856ab772?auto=format&fit=crop&w=1950&q=80',
            'https://images.unsplash.com/photo-1511920170033-f8396924c348?auto=format&fit=crop&w=1950&q=80',
            'https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=1950&q=80'
        ]
    }" x-init="setInterval(() => { active = (active + 1) % slides.length }, 5000)" class="relative h-screen overflow-hidden pt-16">
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="active===index" x-transition.opacity.duration.1500ms
                class="absolute inset-0 bg-cover bg-center parallax-bg"
                :style="'background-image: url(' + slide + ')'">
                <div
                    class="absolute inset-0 bg-gradient-to-b from-slate-950/80 via-slate-950/40 to-slate-950 flex flex-col justify-center items-center text-center text-white px-4">
                    {{-- Judul Utama --}}
                    <h1 class="text-7xl md:text-9xl mb-0 drop-shadow-2xl reveal font-longa leading-none uppercase">
                        ZOCCO GROUP
                    </h1>

                    {{-- Sub-judul: md:-mt-4 menarik teks naik di laptop --}}
                    <p
                        class="text-[12px] md:text-2xl -mt-1 md:-mt-4 mb-6 md:mb-8 text-gray-300 font-light tracking-[0.2em] reveal uppercase leading-none">
                        GOOD FOOD MEETS GREAT COFFEE
                    </p>

                    {{-- Tombol --}}
                    <a href="#outlets"
                        class="bg-yellow-600 hover:bg-yellow-700 px-6 py-3 md:px-10 md:py-4 rounded-full text-white text-sm md:text-base font-semibold shadow-2xl transition transform hover:scale-105 reveal">
                        Jelajahi Sekarang
                    </a>
                </div>
            </div>
        </template>
    </section>

    {{-- Outlets Section --}}
    <section id="outlets" class="py-24 bg-slate-950 relative">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-4xl md:text-5xl font-serif italic mb-4 text-white reveal">Jelajahi Cabang Kami</h2>
            <div class="mx-auto mb-12 w-20 h-1 bg-yellow-600 rounded-full reveal"></div>
            <div class="horizontal-scroll-container flex space-x-8 pb-10 reveal items-stretch">
                @forelse ($outlets as $outlet)
                    <div
                        class="w-80 flex-shrink-0 bg-slate-900 rounded-[2rem] shadow-2xl overflow-hidden relative group border border-white/5 hover:border-yellow-600/30 transition-all duration-500">
                        <div class="overflow-hidden h-56">
                            <img src="{{ $outlet->image ? asset('storage/' . $outlet->image) : 'https://images.unsplash.com/photo-1538350172159-4d64157d0796?auto=format&fit=crop&w=800&q=80' }}"
                                class="w-full h-full object-cover transform group-hover:scale-110 transition-all duration-700">
                        </div>
                        <div class="p-8 text-center">
                            <h3 class="font-serif italic text-2xl mb-2 text-white">{{ $outlet->name }}</h3>
                            <p class="text-gray-500 mb-6 text-sm uppercase tracking-widest">{{ $outlet->city }}</p>
                            <a href="{{ route('outlet.detail', $outlet->id) }}" target="_blank"
                                class="inline-block px-8 py-2 border border-yellow-600 text-yellow-600 rounded-full font-semibold hover:bg-yellow-600 hover:text-white transition-all">Detail</a>
                        </div>
                    </div>
                @empty
                    <div class="w-full text-center py-10">
                        <p class="text-gray-500 italic">Belum ada cabang yang terdaftar.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Coffee Beans Section --}}
    <section id="produk" class="py-24 bg-slate-900">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-end mb-12 border-l-4 border-yellow-600 pl-6">
                <div>
                    <h2 class="text-4xl font-serif italic text-white">Coffee Beans</h2>
                    <p class="text-gray-500 uppercase tracking-widest text-xs mt-1">Pilihan biji kopi terbaik</p>
                </div>
                <a href="{{ route('products') }}"
                    class="text-yellow-600 font-semibold hover:text-yellow-500 transition-colors">Lihat Semua
                    &rarr;</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($beans as $bean)
                    <div
                        class="bg-slate-950 p-5 rounded-[2rem] shadow-xl border border-white/5 hover:border-yellow-600/20 transition-all reveal">
                        <img src="{{ asset('storage/' . $bean->image_url) }}"
                            class="w-full h-56 object-cover rounded-2xl mb-6 shadow-lg">
                        <h3 class="font-serif italic text-xl text-white mb-2">{{ $bean->name }}</h3>
                        <p class="text-yellow-600 font-bold text-lg">Rp
                            {{ number_format($bean->price_250g, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Merchandise Section --}}
    <section class="py-24 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-end mb-12 border-l-4 border-yellow-600 pl-6">
                <div>
                    <h2 class="text-4xl font-serif italic text-white">Merchandise</h2>
                    <p class="text-gray-500 uppercase tracking-widest text-xs mt-1">Koleksi eksklusif kami</p>
                </div>
                <a href="{{ route('products') }}"
                    class="text-yellow-600 font-semibold hover:text-yellow-500 transition-colors">Lihat Semua
                    &rarr;</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Gunakan unique('name') untuk menyaring produk dengan nama yang sama --}}
                @foreach ($merchandises->unique('name') as $merch)
                    <div class="bg-slate-900 p-5 rounded-[2rem] shadow-xl border border-white/5 reveal">
                        <img src="{{ asset('storage/' . $merch->image_url) }}"
                            class="w-full h-56 object-cover rounded-2xl mb-6 shadow-lg">
                        <h3 class="font-serif italic text-xl text-white mb-2">{{ $merch->name }}</h3>
                        <p class="text-yellow-600 font-bold text-lg">Rp
                            {{ number_format($merch->price, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    {{-- About Section --}}
    <section id="about" class="py-24 bg-slate-900 overflow-hidden">
        <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row items-center gap-16">

            <div class="w-full md:w-1/2 reveal relative">
                <div class="absolute -top-4 -left-4 w-full h-full border-2 border-yellow-600 rounded-2xl"></div>

                {{-- Mengambil gambar dari variabel $slogan yang dikirim controller --}}
                {{-- Jika data di database (kolom image) ada, maka tampilkan. Jika tidak, pakai placeholder --}}
                <img src="{{ isset($slogan) && $slogan->image ? asset('storage/' . $slogan->image) : 'https://images.unsplash.com/photo-1511920170033-f8396924c348?auto=format&fit=crop&w=800&q=80' }}"
                    class="relative z-10 rounded-2xl shadow-2xl grayscale hover:grayscale-0 transition-all duration-700 w-full h-[400px] object-cover">
            </div>

            <div class="w-full md:w-1/2 text-center md:text-left reveal">
                <h2 class="text-4xl font-serif italic text-white mb-6">Tentang Zocco Coffee</h2>
                {{-- Teks tidak akan lari ke samping karena ada class 'break-words' --}}
                <div class="mb-8 text-gray-400 leading-relaxed font-light text-lg break-words">
                    {{ $deskripsi->value ?? 'Deskripsi belum diatur' }}
                </div>
                <a href="#contact"
                    class="inline-block bg-yellow-600 hover:bg-yellow-700 px-10 py-4 rounded-full text-white font-semibold shadow-xl transition transform hover:scale-105">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    {{-- Gallery Section --}}
    <section id="gallery" class="py-24 relative overflow-hidden bg-slate-950">
        <div class="absolute inset-0 -z-10">
            <div
                class="absolute -top-16 -left-16 w-96 h-96 bg-yellow-600/10 rounded-full blur-[120px] animate-pulse-slow">
            </div>
            <div
                class="absolute -bottom-16 -right-16 w-96 h-96 bg-blue-600/5 rounded-full blur-[120px] animate-pulse-slow">
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-4xl md:text-5xl font-serif italic mb-16 text-white reveal">Galeri Zocco Coffee</h2>
            <div class="gallery-masonry columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-6 space-y-6"
                x-data="{ images: {{ $galleries->map(function ($item) {return ['src' => asset('storage/' . $item->image_path), 'judul' => $item->judul, 'h' => ['h-48', 'h-72', 'h-56', 'h-80'][rand(0, 3)]];}) }} }">
                <template x-for="img in images" :key="img.src">
                    <div
                        class="reveal relative group overflow-hidden rounded-[1.5rem] shadow-xl border border-white/5 transition-all duration-500">
                        <img :src="img.src"
                            :class="img.h +
                                ' w-full object-cover transform transition-all duration-1000 group-hover:scale-110 group-hover:rotate-1'">
                        <div
                            class="absolute inset-0 bg-slate-950/60 opacity-0 group-hover:opacity-100 flex flex-col items-center justify-center transition-all duration-500 backdrop-blur-sm">
                            <span class="text-white text-lg font-serif italic" x-text="img.judul"></span>
                            <div class="w-10 h-0.5 bg-yellow-600 mt-2"></div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>
    {{-- Contact Section --}}
    <section id="contact" class="py-20 bg-slate-900 border-t border-white/5">
        <div class="max-w-4xl mx-auto px-4">
            <div class="text-center reveal">
                <h2 class="text-4xl font-serif italic text-white mb-4">Hubungi Kami.</h2>
                <p class="text-gray-400 mb-8 font-light leading-relaxed max-w-2xl mx-auto">
                    Punya pertanyaan atau ingin reservasi tempat? Kami siap melayani momen spesial Anda. Silakan hubungi
                    kami melalui kontak di bawah ini.
                </p>

                <div class="flex flex-col md:flex-row justify-center items-center gap-8 md:gap-16">
                    <div class="flex items-center space-x-4 text-sm">
                        <span class="w-8 h-[1px] bg-yellow-600"></span>
                        <span class="text-gray-300">Jl. Kopi No.123, Malang</span>
                    </div>
                    <div class="flex items-center space-x-4 text-sm">
                        <span class="w-8 h-[1px] bg-yellow-600"></span>
                        <span class="text-gray-300">+62 812 3456 7890</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-slate-950 py-10 border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-center md:text-left">
                <h3 class="font-serif italic text-xl text-white">Zocco Coffee.</h3>
                <p class="text-gray-600 text-[10px] uppercase tracking-[0.2em] mt-1">&copy; 2025 Crafted with Passion
                </p>
            </div>

            <div class="flex flex-wrap justify-center gap-6">
                {{-- Link WhatsApp --}}
                <a href="https://wa.me/6281234567890?text=Halo%20Zocco%20Coffee" target="_blank"
                    class="text-gray-500 hover:text-yellow-600 transition-all uppercase text-[10px] font-bold tracking-widest flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.588-5.946 0-6.556 5.332-11.891 11.892-11.891 3.181 0 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.481 8.403 0 6.556-5.332 11.891-11.891 11.891-2.012 0-3.987-.511-5.733-1.482l-6.262 1.701zm6.275-3.877c1.551.921 3.076 1.408 4.606 1.408 5.201 0 9.431-4.23 9.431-9.431 0-2.521-.982-4.891-2.766-6.674-1.783-1.783-4.155-2.766-6.67-2.766-5.201 0-9.432 4.231-9.432 9.432 0 1.774.498 3.415 1.442 4.761l-1.042 3.804 3.931-1.066zm10.706-6.696c-.29-.145-1.714-.847-1.98-.942-.266-.096-.459-.145-.653.145-.193.291-.748.943-.917 1.137-.169.194-.338.217-.627.072-.291-.145-1.226-.452-2.336-1.442-.863-.77-1.446-1.72-1.615-2.011-.17-.291-.018-.448.127-.592.13-.13.29-.339.436-.509.145-.17.194-.291.29-.485.097-.194.048-.364-.024-.509-.072-.145-.653-1.574-.894-2.156-.234-.565-.472-.488-.653-.497-.169-.008-.362-.01-.555-.01s-.507.072-.772.363c-.266.291-1.015.992-1.015 2.42s1.039 2.81 1.185 3.004c.145.194 2.043 3.12 4.95 4.378.692.299 1.232.478 1.652.611.696.221 1.33.19 1.831.115.558-.083 1.714-.701 1.956-1.38.241-.679.241-1.26.17-1.38-.072-.121-.266-.194-.556-.339z" />
                    </svg>
                    WhatsApp
                </a>

                {{-- Link Email --}}
                <a href="mailto:zoccocoffee@email.com?subject=Tanya%20Zocco%20Coffee"
                    class="text-gray-500 hover:text-yellow-600 transition-all uppercase text-[10px] font-bold tracking-widest flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Email
                </a>

                <a href="#"
                    class="text-gray-500 hover:text-yellow-600 transition-all uppercase text-[10px] font-bold tracking-widest">Instagram</a>
            </div>
        </div>
    </footer>
    <script>
        // ScrollReveal Configuration
        ScrollReveal().reveal('.reveal', {
            delay: 200,
            distance: '30px',
            origin: 'bottom',
            duration: 1000,
            easing: 'cubic-bezier(0.5, 0, 0, 1)',
            interval: 150
        });

        // Parallax Effect
        window.addEventListener('scroll', () => {
            const scrollPosition = window.pageYOffset;
            document.querySelectorAll('.parallax-bg').forEach(bg => {
                bg.style.backgroundPositionY = (scrollPosition * 0.4) + 'px';
            });
        });
    </script>
</body>

</html>
