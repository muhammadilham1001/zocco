<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Lengkap - {{ $outlet->name }}</title>
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        h1,
        h2,
        h3 {
            font-family: 'Playfair Display', serif;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        [x-cloak] {
            display: none !important;
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .dark .glass-nav {
            background: rgba(15, 23, 42, 0.8);
        }
    </style>
</head>

<body class="bg-[#fcfaf7] dark:bg-slate-950 transition-colors duration-500" x-data="{
    search: '',
    darkMode: true,
    isSearching() { return this.search.trim() !== '' }
}"
    :class="{ 'dark': darkMode }">

    <header class="glass-nav sticky top-0 w-full z-50 border-b border-gray-100 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ url('/outlet/' . $outlet->id) }}"
                        class="p-2 hover:bg-gray-100 dark:hover:bg-slate-800 rounded-full transition text-yellow-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-xl font-black dark:text-white uppercase tracking-tight leading-none">DAFTAR MENU
                        </h1>
                        <p class="text-[10px] text-gray-500 uppercase tracking-[0.2em] font-bold mt-1">
                            {{ $outlet->name }}</p>
                    </div>
                </div>

                <div class="relative w-full max-w-md mx-auto">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input x-model="search" type="text" placeholder="Cari menu favorit..."
                        class="w-full pl-10 pr-4 py-3 bg-gray-100 dark:bg-slate-800 border-none rounded-2xl focus:ring-2 focus:ring-yellow-600 dark:text-white transition-all text-sm outline-none">
                </div>
            </div>
        </div>
    </header>

    <nav class="bg-white dark:bg-slate-900 border-b dark:border-slate-800 sticky top-[150px] md:top-[81px] z-40 overflow-x-auto scrollbar-hide"
        x-show="!isSearching()">
        <div class="max-w-7xl mx-auto px-4 flex space-x-8 py-4 justify-center whitespace-nowrap">
            @foreach ($categories as $cat)
                <a href="#cat-{{ $cat->id }}"
                    class="text-xs font-black uppercase tracking-widest text-gray-400 hover:text-yellow-600 transition-all border-b-2 border-transparent hover:border-yellow-600 pb-1">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </nav>

    <main class="py-12 px-4 max-w-7xl mx-auto min-h-screen">
        @foreach ($categories as $cat)
            @php $categoryMenus = $menus->where('category_id', $cat->id); @endphp
            <section id="cat-{{ $cat->id }}" class="mb-16 scroll-mt-32"
                x-show="!isSearching() || $el.querySelectorAll('[data-name*=\'' + search.toLowerCase() + '\']').length > 0">

                <div class="flex items-center gap-6 mb-8" x-show="!isSearching()">
                    <h2 class="text-3xl font-black dark:text-white italic uppercase tracking-tighter">
                        {{ $cat->name }}</h2>
                    <div class="flex-1 h-[1px] bg-gray-200 dark:bg-slate-800"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($categoryMenus as $item)
                        <div class="bg-white dark:bg-slate-900 rounded-[2.2rem] p-3 shadow-sm border border-gray-100 dark:border-slate-800 flex items-center gap-4 transition-all hover:shadow-xl {{ !$item->is_available ? 'opacity-75' : '' }}"
                            data-name="{{ strtolower($item->name) }}"
                            x-show="search === '' || $el.getAttribute('data-name').includes(search.toLowerCase())"
                            x-transition>

                            <div
                                class="w-28 h-28 md:w-32 md:h-32 flex-shrink-0 rounded-[1.8rem] overflow-hidden bg-gray-100 relative">
                                <img src="{{ asset('storage/' . $item->image_url) }}"
                                    class="w-full h-full object-cover {{ !$item->is_available ? 'grayscale contrast-75' : '' }}"
                                    onerror="this.src='https://via.placeholder.com/200?text=Kopi'">

                                @if (!$item->is_available)
                                    <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                                        <span
                                            class="bg-red-600 text-white text-[8px] font-black uppercase px-2 py-1 rounded-md rotate-12 shadow-lg">Habis</span>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0 pr-2">
                                <h3
                                    class="font-bold text-lg md:text-xl dark:text-white leading-tight mb-1 truncate {{ !$item->is_available ? 'text-gray-400' : '' }}">
                                    {{ $item->name }}
                                </h3>
                                <p
                                    class="text-gray-400 text-xs font-light italic break-words line-clamp-2 mb-3 leading-relaxed">
                                    {{ $item->description ?? 'Deskripsi rasa unik khas Zocco Coffee.' }}
                                </p>

                                <div class="flex justify-between items-center">
                                    <span class="text-yellow-600 font-black text-lg">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </span>

                                    @if ($item->is_available)
                                        <span
                                            class="text-[10px] text-green-600 dark:text-green-400 font-bold uppercase tracking-widest border border-green-100 dark:border-green-900/30 px-3 py-1 rounded-full bg-green-50 dark:bg-green-900/20">
                                            Available
                                        </span>
                                    @else
                                        <span
                                            class="text-[10px] text-red-500 font-bold uppercase tracking-widest border border-red-100 dark:border-red-900/30 px-3 py-1 rounded-full bg-red-50 dark:bg-red-900/20">
                                            Sold Out
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach
    </main>

    <footer
        class="py-12 border-t border-gray-100 dark:border-slate-800 text-center text-[10px] font-black text-gray-400 uppercase tracking-widest">
        © 2026 Zocco Coffee Indonesia
    </footer>

    <script>
        // Smooth scroll untuk navigasi kategori
        document.querySelectorAll('nav a').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) window.scrollTo({
                    top: target.offsetTop - 140,
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>

</html>
