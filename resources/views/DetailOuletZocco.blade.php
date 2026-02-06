<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $outlet->name }}</title>
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Poppins:wght@200;300;400;500;600&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        h1,
        h2,
        h3,
        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }

        .hero-mask {
            background: linear-gradient(to top, #0f172a 5%, rgba(15, 23, 42, 0.3) 50%, rgba(15, 23, 42, 0.1) 100%);
        }

        [x-cloak] {
            display: none !important;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .float-anim {
            animation: float 4s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-[#fcfaf7] dark:bg-slate-950 transition-colors duration-500" x-data="{
    darkMode: true,
    activeCategory: 'all',
    scrolled: false
}"
    @scroll.window="scrolled = (window.pageYOffset > 50)" :class="{ 'dark': darkMode }">

    {{-- NAVIGATION --}}
    <nav class="fixed w-full z-[100] transition-all duration-300 px-6 py-4"
        :class="scrolled ? 'top-0 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md shadow-lg py-3' : 'top-4'">
        <div
            class="max-w-7xl mx-auto flex justify-between items-center bg-white dark:bg-slate-900 rounded-2xl px-6 py-3 shadow-sm border border-gray-100 dark:border-slate-800">
            <div class="flex items-center gap-4">
                {{-- LOGO DINAMIS --}}
                @if ($outlet->logo)
                    <img src="{{ asset('storage/' . $outlet->logo) }}" class="w-10 h-10 object-contain"
                        alt="Logo {{ $outlet->name }}">
                @else
                    <div
                        class="w-10 h-10 bg-yellow-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                        Z</div>
                @endif
                <span class="font-serif font-bold text-xl tracking-tight dark:text-white">{{ $outlet->name }}.</span>
            </div>

            <div
                class="hidden md:flex gap-8 items-center text-xs font-semibold tracking-widest uppercase text-gray-500 dark:text-gray-400">
                <a href="#hero" class="hover:text-yellow-600 transition">Home</a>
                <a href="#menu-section" class="hover:text-yellow-600 transition">Menu</a>
                <a href="#footer" class="hover:text-yellow-600 transition">Contact</a>
            </div>

            <div class="flex items-center gap-3">
                {{-- <button @click="darkMode = !darkMode"
                    class="p-2 hover:bg-gray-100 dark:hover:bg-slate-800 rounded-full transition text-yellow-600">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"
                            stroke-width="2" />
                    </svg>
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 3v1m0 18v1m9-9h1M3 12h1m15.364-6.364l-.707.707M6.343 17.657l-.707.707M16.95 16.95l.707.707M7.636 7.636l.707-.707M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                            stroke-width="2" />
                    </svg>
                </button> --}}
                <div class="h-4 w-[1px] bg-gray-200"></div>
                <a href="{{ route('user.reservation') }}"
                    class="bg-slate-900 dark:bg-yellow-600 text-white px-5 py-2 rounded-xl text-xs font-bold hover:scale-105 transition active:scale-95">RESERVATION
                </a>
            </div>
        </div>
    </nav>

    {{-- HERO SECTION --}}
    <section id="hero" class="relative h-screen flex items-center justify-center overflow-hidden bg-slate-900">
        {{-- BACKGROUND DINAMIS --}}
        <img src="{{ $outlet->image ? asset('storage/' . $outlet->image) : 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=2000' }}"
            class="absolute inset-0 w-full h-full object-cover opacity-60 scale-110 transition-transform duration-[10s]"
            id="hero-img">

        <div class="absolute inset-0 hero-mask"></div>

        <div class="relative z-10 text-center px-6">
            <div
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 mb-8 float-anim">
                <span class="relative flex h-2 w-2">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                </span>
                <span class="text-white text-[10px] font-bold tracking-widest uppercase">Open Now •
                    {{ $outlet->city }}</span>
            </div>
            <h1 class="text-6xl md:text-9xl text-white font-bold tracking-tighter mb-4 italic uppercase">
                {{ $outlet->name }}</h1>
            <p class="text-white/70 text-lg md:text-xl font-light tracking-wide max-w-2xl mx-auto mb-12 italic">
                {{ $outlet->city }}
            </p>
            <div class="flex justify-center">
                <a href="#menu-section"
                    class="group relative px-10 py-4 overflow-hidden rounded-full bg-yellow-600 text-white font-bold transition-all shadow-2xl shadow-yellow-600/20">
                    <span class="relative z-10">EXPLORE MENU</span>
                    <div
                        class="absolute inset-0 bg-white translate-y-[101%] group-hover:translate-y-0 transition-transform duration-300">
                    </div>
                    <span
                        class="absolute inset-0 z-20 flex items-center justify-center text-slate-900 opacity-0 group-hover:opacity-100 transition-opacity font-bold uppercase tracking-widest text-xs">Let's
                        Order</span>
                </a>
            </div>
        </div>
    </section>

    {{-- MENU SECTION --}}
    <main id="menu-section" class="max-w-7xl mx-auto px-6 py-32">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-20 gap-8">
            <div class="max-w-md">
                <h2 class="text-5xl font-bold dark:text-white mb-4 italic">Crafted Selection</h2>
                <p class="text-gray-500 dark:text-gray-400">Pilihan menu terbaik kami untuk melengkapi momen spesial
                    Anda di <strong>{{ $outlet->name }}</strong>.</p>
            </div>

            {{-- KATEGORI FILTER --}}
            <div
                class="flex flex-wrap gap-2 p-1.5 bg-white dark:bg-slate-900 border dark:border-slate-800 rounded-2xl shadow-sm">
                <button @click="activeCategory = 'all'"
                    :class="activeCategory === 'all' ? 'bg-yellow-600 text-white shadow-md' :
                        'text-gray-500 hover:bg-gray-50 dark:hover:bg-slate-800'"
                    class="px-6 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all">ALL</button>
                @foreach ($categories as $cat)
                    <button @click="activeCategory = '{{ $cat->name }}'"
                        :class="activeCategory === '{{ $cat->name }}' ? 'bg-yellow-600 text-white shadow-md' :
                            'text-gray-500 hover:bg-gray-50 dark:hover:bg-slate-800'"
                        class="px-6 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all uppercase">{{ $cat->name }}</button>
                @endforeach
            </div>
        </div>

        {{-- GRID MENU --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            {{-- Tambahkan ->take(6) setelah variabel $menus --}}
            @forelse($menus->take(6) as $menu)
                <div x-show="activeCategory === 'all' || activeCategory === '{{ $menu->category->name ?? '' }}'"
                    x-transition
                    class="group bg-white dark:bg-slate-900 rounded-[2.5rem] p-4 shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 dark:border-slate-800"
                    x-cloak>

                    {{-- Isi konten menu tetap sama --}}
                    <div class="relative h-72 rounded-[2rem] overflow-hidden mb-6">
                        <img src="{{ asset('storage/' . $menu->image_url) }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                            onerror="this.src='https://via.placeholder.com/600x600?text=Menu+Zocco'">
                        <div
                            class="absolute top-4 right-4 bg-white/90 backdrop-blur px-4 py-1.5 rounded-full text-[10px] font-black text-yellow-700 uppercase italic shadow-sm">
                            {{ $menu->category->name ?? 'Zocco' }}
                        </div>
                    </div>
                    <div class="px-4 pb-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-2xl font-bold dark:text-white leading-tight pr-4">{{ $menu->name }}</h3>
                            <span
                                class="text-xl font-serif italic text-yellow-600 whitespace-nowrap">Rp{{ number_format($menu->price / 1000, 0) }}k</span>
                        </div>
                        <p
                            class="text-gray-400 text-xs leading-relaxed mb-6 font-light italic break-words line-clamp-2">
                            {{ $menu->description ?? 'Nikmati sensasi rasa unik yang diracik khusus untuk menemani harimu di Zocco Coffee.' }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 text-gray-500 italic">Maaf, menu belum tersedia.</div>
            @endforelse
        </div>

        <div class="mt-20 flex justify-center">
            <a href="{{ route('DetailMenu', $outlet->id) }}"
                class="group flex items-center gap-4 bg-slate-900 dark:bg-yellow-600 text-white px-12 py-5 rounded-full font-black text-sm tracking-[0.2em] uppercase hover:scale-105 transition-all shadow-2xl hover:shadow-yellow-600/20">
                <span>Tampilkan Semua Menu</span>
                <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </main>

    {{-- FOOTER --}}
    <footer id="footer" class="bg-white dark:bg-slate-900 border-t dark:border-slate-800 py-24">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-4 gap-16">
            <div class="lg:col-span-2">
                {{-- LOGO DINAMIS FOOTER --}}
                <div class="flex items-center gap-4 mb-6">
                    @if ($outlet->logo)
                        <img src="{{ asset('storage/' . $outlet->logo) }}" class="w-12 h-12 object-contain"
                            alt="Logo {{ $outlet->name }}">
                    @endif
                    <h3 class="text-4xl font-bold dark:text-white italic">{{ $outlet->name }}.</h3>
                </div>
                <p class="text-gray-400 font-light max-w-sm leading-relaxed mb-8">
                    Kunjungi kami di cabang <strong>{{ $outlet->city }}</strong>. Kami siap menyajikan kualitas kopi
                    terbaik untuk Anda.
                </p>
            </div>

            <div>
                <h4 class="font-bold dark:text-white mb-6 uppercase text-xs tracking-widest">Store Info</h4>
                <ul class="text-sm text-gray-500 space-y-3">
                    <li class="flex flex-col">
                        <span class="text-xs text-gray-400 uppercase tracking-tighter">Email</span>
                        <span class="text-gray-900 dark:text-white font-bold">{{ $outlet->email ?? '-' }}</span>
                    </li>
                    <li class="flex flex-col">
                        <span class="text-xs text-gray-400 uppercase tracking-tighter">Location</span>
                        <span
                            class="text-gray-900 dark:text-white font-bold">{{ $outlet->city ?? 'Indonesia' }}</span>
                    </li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold dark:text-white mb-6 uppercase text-xs tracking-widest">Connect</h4>
                <div class="flex flex-wrap gap-4">
                    {{-- Instagram --}}
                    @if ($outlet->ig)
                        <a href="https://instagram.com/{{ ltrim($outlet->ig, '@') }}" target="_blank"
                            class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-slate-800 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-gradient-to-tr hover:from-yellow-400 hover:to-purple-600 hover:text-white transition-all duration-300 shadow-sm hover:shadow-lg hover:-translate-y-1"
                            title="Instagram">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                    @endif

                    {{-- WhatsApp --}}
                    @if ($outlet->wa)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $outlet->wa) }}" target="_blank"
                            class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-slate-800 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-[#25D366] hover:text-white transition-all duration-300 shadow-sm hover:shadow-lg hover:-translate-y-1"
                            title="WhatsApp">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.438 9.889-9.886.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                            </svg>
                        </a>
                    @endif

                    {{-- TikTok --}}
                    @if ($outlet->tt)
                        <a href="https://tiktok.com/@{{ ltrim($outlet - > tt, '@') }}" target="_blank"
                            class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-slate-800 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-black hover:text-white transition-all duration-300 shadow-sm hover:shadow-lg hover:-translate-y-1"
                            title="TikTok">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 103.91 11.4 6.73 6.73 0 001.01-5.13V8.66a8.13 8.13 0 005.42 2.04V7.27a4.91 4.91 0 01-1.12-.58z" />
                            </svg>
                        </a>
                    @endif

                    {{-- Fallback jika tidak ada data sosmed --}}
                    @if (!$outlet->ig && !$outlet->wa && !$outlet->tt)
                        <span class="text-xs text-gray-500 italic">Social media not available</span>
                    @endif
                </div>
            </div>
        </div>
        {{-- FOOTER BOTTOM - VERSI RINGKAS --}}
        <div
            class="max-w-5xl mx-auto px-6 mt-10 pt-6 border-t border-gray-100 dark:border-slate-800 flex flex-col md:flex-row justify-between items-center gap-4 text-[9px] md:text-[10px] text-gray-400 font-bold uppercase tracking-widest">
            <p class="text-center md:text-left">© 2026 Zocco Coffee Indonesia - {{ $outlet->name }}</p>
            <p class="hidden sm:block opacity-50">Designed for Excellence</p>
        </div>
    </footer>

    <script>
        window.addEventListener('scroll', function() {
            const distance = window.scrollY;
            const img = document.getElementById('hero-img');
            if (img) img.style.transform = `scale(1.1) translateY(${distance * 0.3}px)`;
        });
    </script>
</body>

</html>
