{{-- Full Code SidebarAdmin.blade.php --}}
<aside {{-- Perbaikan: Memastikan x-show sinkron dengan ukuran layar --}} x-show="window.innerWidth < 1024 ? sidebarOpen : true"
    @resize.window="sidebarOpen = window.innerWidth < 1024 ? false : true"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" {{-- PERBAIKAN UTAMA: Tambahkan h-screen dan sticky/fixed agar selalu full ke bawah --}}
    class="fixed lg:sticky top-0 inset-y-0 left-0 z-50 w-64 h-screen bg-slate-950 border-r border-white/5 shadow-2xl p-5 flex flex-col lg:translate-x-0 transition-transform duration-300 ease-in-out"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

    {{-- Efek Dekorasi Latar Belakang --}}
    <div class="absolute top-0 left-0 w-24 h-24 bg-yellow-600/10 rounded-full blur-[60px] -z-10"></div>
    <div class="absolute bottom-0 right-0 w-24 h-24 bg-blue-600/5 rounded-full blur-[60px] -z-10"></div>

    <div class="flex flex-col h-full relative z-10 overflow-hidden">
        {{-- Header: Logo --}}
        <div class="flex items-center justify-between mb-6 flex-shrink-0">
            <div class="flex items-center space-x-3">
                <div
                    class="w-9 h-9 bg-yellow-600 rounded-lg flex items-center justify-center text-white font-bold text-lg shadow-lg rotate-3">
                    Z
                </div>
                <div>
                    <h2 class="text-base font-serif italic tracking-tighter text-white leading-none">Zocco Coffee</h2>
                    <p class="text-[8px] text-gray-500 uppercase tracking-widest mt-1">Admin Panel</p>
                </div>
            </div>
            {{-- Tombol Tutup Mobile --}}
            <button @click="sidebarOpen = false" class="text-gray-500 hover:text-white lg:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Profil Administrator (Posisi Atas) --}}
        <div class="mb-8 p-3 rounded-2xl bg-white/5 border border-white/10 flex items-center space-x-3 flex-shrink-0">
            <div class="relative flex-shrink-0">
                    <img src="{{ asset('icon.png') }}" class="w-10 h-10 rounded-xl object-cover">
                <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 border-2 border-slate-950 rounded-full">
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-bold text-white truncate">Administrator</p>
                <div class="flex items-center">
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                    <p class="text-[9px] text-gray-400 uppercase tracking-widest">Online</p>
                </div>
            </div>
        </div>

        {{-- Navigasi Utama --}}
        <nav class="space-y-1.5 flex-1 overflow-y-auto custom-scrollbar pr-1">
            @php
                $base_classes =
                    'flex items-center space-x-3 px-3 py-3 rounded-xl text-xs font-medium transition-all duration-200 group relative';
                $default_classes = 'text-gray-400 hover:text-white hover:bg-white/5';
                $active_classes = 'bg-yellow-600/10 text-yellow-500 border border-yellow-600/20';
            @endphp

            <a href="{{ route('DashboardAdmin') }}"
                class="{{ $base_classes }} {{ request()->routeIs('DashboardAdmin') ? $active_classes : $default_classes }}">
                @if (request()->routeIs('DashboardAdmin'))
                    <div
                        class="absolute left-0 w-1 h-4 bg-yellow-600 rounded-r-full shadow-[0_0_8px_rgba(202,138,4,0.6)]">
                    </div>
                @endif
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('ManajemenMenu') }}"
                class="{{ $base_classes }} {{ request()->routeIs('ManajemenMenu') ? $active_classes : $default_classes }}">
                @if (request()->routeIs('ManajemenMenu'))
                    <div
                        class="absolute left-0 w-1 h-4 bg-yellow-600 rounded-r-full shadow-[0_0_8px_rgba(202,138,4,0.6)]">
                    </div>
                @endif
                <i data-lucide="coffee" class="w-4 h-4"></i>
                <span>Daftar Menu</span>
            </a>

            <a href="{{ route('ManajemenBeanmer') }}"
                class="{{ $base_classes }} {{ request()->routeIs('ManajemenBeanmer') ? $active_classes : $default_classes }}">
                @if (request()->routeIs('ManajemenBeanmer'))
                    <div
                        class="absolute left-0 w-1 h-4 bg-yellow-600 rounded-r-full shadow-[0_0_8px_rgba(202,138,4,0.6)]">
                    </div>
                @endif
                <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                <span>Beans & Merch</span>
            </a>

            <a href="{{ route('Manajemenoutlet') }}"
                class="{{ $base_classes }} {{ request()->routeIs('Manajemenoutlet') ? $active_classes : $default_classes }}">
                @if (request()->routeIs('Manajemenoutlet'))
                    <div
                        class="absolute left-0 w-1 h-4 bg-yellow-600 rounded-r-full shadow-[0_0_8px_rgba(202,138,4,0.6)]">
                    </div>
                @endif
                <i data-lucide="map-pin" class="w-4 h-4"></i>
                <span>Data Outlet</span>
            </a>

            <a href="{{ route('ManajemenKategori') }}"
                class="{{ $base_classes }} {{ request()->routeIs('ManajemenKategori') ? $active_classes : $default_classes }}">
                @if (request()->routeIs('ManajemenKategori'))
                    <div
                        class="absolute left-0 w-1 h-4 bg-yellow-600 rounded-r-full shadow-[0_0_8px_rgba(202,138,4,0.6)]">
                    </div>
                @endif
                <i data-lucide="layers" class="w-4 h-4"></i>
                <span>Kategori</span>
            </a>

            <a href="{{ route('Reservation') }}"
                class="{{ $base_classes }} {{ request()->routeIs('Reservation') ? $active_classes : $default_classes }}">
                @if (request()->routeIs('Reservation'))
                    <div
                        class="absolute left-0 w-1 h-4 bg-yellow-600 rounded-r-full shadow-[0_0_8px_rgba(202,138,4,0.6)]">
                    </div>
                @endif
                <i data-lucide="calendar-check" class="w-4 h-4"></i>
                <span>Reservasi</span>
            </a>

            <a href="{{ route('ManajemenDashboard') }}"
                class="{{ $base_classes }} {{ request()->routeIs('ManajemenDashboard') ? $active_classes : $default_classes }}">
                @if (request()->routeIs('ManajemenDashboard'))
                    <div
                        class="absolute left-0 w-1 h-4 bg-yellow-600 rounded-r-full shadow-[0_0_8px_rgba(202,138,4,0.6)]">
                    </div>
                @endif
                <i data-lucide="settings" class="w-4 h-4"></i>
                <span>Sistem</span>
            </a>
        </nav>

        {{-- Footer: Logout --}}
        <div class="mt-auto pt-4 border-t border-white/10 flex-shrink-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center space-x-2 py-3 rounded-xl
                    bg-red-500/5 text-red-500 font-bold text-[10px] uppercase tracking-widest border border-red-500/10
                    hover:bg-red-500 hover:text-white transition-all duration-300 group">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>

{{-- Overlay Mask Mobile --}}
<div x-show="sidebarOpen" @click="sidebarOpen = false"
    class="fixed inset-0 z-40 bg-slate-950/60 backdrop-blur-sm lg:hidden" x-transition:opacity x-cloak>
</div>

<style>
    /* Mencegah flickering saat loading AlpineJS */
    [x-cloak] {
        display: none !important;
    }

    /* Memastikan body tidak bisa scroll ke samping */
    body {
        overflow-x: hidden;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
    }
</style>
