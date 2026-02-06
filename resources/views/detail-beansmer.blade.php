<!DOCTYPE html>
<html lang="id">

@include('layouts.HeadAdmin')

<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-500 ease-in-out font-poppins"
    x-data="{ tab: 'beans', search: '' }">

    <nav class="bg-white dark:bg-gray-800 shadow-sm border-b dark:border-gray-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-3 h-20 items-center">

                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}"
                        class="text-gray-500 hover:text-yellow-600 transition p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <span
                        class="text-xl font-bold text-gray-900 dark:text-white hidden lg:block tracking-tight">KATALOG</span>
                </div>

                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input x-model="search" type="text" placeholder="Cari kopi atau merchandise..."
                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-2xl bg-gray-50 dark:bg-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-500 focus:border-transparent outline-none transition-all shadow-sm">
                </div>

                <div class="flex justify-end">
                </div>

            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto p-6 md:p-8">
        {{-- Tab Switcher --}}
        <div
            class="flex justify-center space-x-2 mb-12 bg-gray-200/50 dark:bg-gray-800/50 p-1.5 rounded-2xl w-fit mx-auto border dark:border-gray-700">
            <button @click="tab = 'beans'"
                :class="tab === 'beans' ? 'bg-white dark:bg-gray-700 text-yellow-600 shadow-md' : 'text-gray-500'"
                class="px-8 py-2.5 rounded-xl font-bold transition-all duration-300">
                Coffee Beans
            </button>
            <button @click="tab = 'merch'"
                :class="tab === 'merch' ? 'bg-white dark:bg-gray-700 text-yellow-600 shadow-md' : 'text-gray-500'"
                class="px-8 py-2.5 rounded-xl font-bold transition-all duration-300">
                Merchandise
            </button>
        </div>

        {{-- Grid Coffee Beans --}}
        <div x-show="tab === 'beans'" x-transition class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ($beans as $bean)
                <div x-show="search === '' || '{{ strtolower($bean->name) }}'.includes(search.toLowerCase()) || '{{ strtolower($bean->origin) }}'.includes(search.toLowerCase())"
                    class="bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-md border border-gray-100 dark:border-gray-700 group hover:shadow-xl transition-all duration-300">
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ asset('storage/' . $bean->image_url) }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div
                            class="absolute bottom-3 left-3 bg-white/90 dark:bg-gray-900/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-bold uppercase dark:text-white shadow-sm border dark:border-gray-700">
                            {{ $bean->origin }}
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">{{ $bean->name }}</h3>
                        <p class="text-gray-400 text-xs mb-4 line-clamp-2 italic">"{{ $bean->description }}"</p>
                        <div class="flex justify-between items-end">
                            <span class="text-xl font-black text-yellow-600">Rp
                                {{ number_format($bean->price_250g, 0, ',', '.') }}</span>
                            <span
                                class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $bean->global_stock_kg }}
                                Kg</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Grid Merchandise --}}
        <div x-show="tab === 'merch'" x-transition class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ($merchandises as $merch)
                <div x-show="search === '' || '{{ strtolower($merch->name) }}'.includes(search.toLowerCase()) || '{{ strtolower($merch->category) }}'.includes(search.toLowerCase())"
                    class="bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-md border border-gray-100 dark:border-gray-700 group hover:shadow-xl transition-all duration-300">
                    <div class="relative h-56 overflow-hidden bg-gray-100 dark:bg-gray-700">
                        <img src="{{ asset('storage/' . $merch->image_url) }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <div
                            class="absolute top-3 right-3 bg-yellow-600 text-white text-[10px] px-3 py-1 rounded-full font-bold uppercase shadow-lg">
                            {{ $merch->category }}
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">{{ $merch->name }}</h3>
                        <div
                            class="flex justify-between items-center bg-gray-50 dark:bg-gray-700/50 p-3 rounded-2xl border dark:border-gray-600">
                            <span class="text-lg font-black text-gray-900 dark:text-white">Rp
                                {{ number_format($merch->price, 0, ',', '.') }}</span>
                            <span
                                class="text-xs font-bold text-green-600 bg-green-100 dark:bg-green-900/30 px-2 py-1 rounded-lg">{{ $merch->global_stock_unit }}
                                Unit</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Empty State --}}
        <div class="mt-20 text-center text-gray-500 dark:text-gray-400 py-10"
            x-show="search !== '' && $el.parentElement.querySelectorAll('.grid > div[style*=\'display: none\']').length === $el.parentElement.querySelectorAll('.grid > div').length">
            <div
                class="bg-gray-200/50 dark:bg-gray-800/50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <p class="text-xl">Produk "<span x-text="search" class="font-bold text-yellow-600"></span>" tidak ditemukan.
            </p>
        </div>

    </main>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @include('layouts.JsAdmin')
</body>

</html>
