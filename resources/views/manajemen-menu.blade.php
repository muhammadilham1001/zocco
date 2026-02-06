<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: false }">

<head>
    @include('layouts.HeadAdmin')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-500 font-poppins overflow-x-hidden">
    <div class="flex h-screen overflow-hidden">
        {{-- SIDEBAR --}}
        {{-- Sidebar sekarang diatur oleh x-show/x-bind yang ada di dalam SidebarAdmin --}}
        @include('layouts.SidebarAdmin')

        {{-- OVERLAY SIDEBAR (Mobile) --}}
        <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/50 z-40 md:hidden">
        </div>

        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">

            <div class="flex-1 p-4 md:p-8 pt-5 md:pt-8 overflow-y-auto">
                {{-- HEADER DENGAN HAMBURGER INTEGRATED --}}
                <header class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                    <div class="flex items-center gap-4">
                        {{-- Tombol Hamburger Mobile --}}
                        <button @click="sidebarOpen = true"
                            class="md:hidden p-2 rounded-xl bg-white dark:bg-gray-800 shadow-sm border dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-6 h-6 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100">Manajemen Menu
                            </h1>
                            <p class="text-gray-500 text-sm hidden md:block">Kelola daftar menu dan ketersediaan produk
                                di setiap outlet.</p>
                        </div>
                    </div>
                </header>

                {{-- NOTIFIKASI SWEETALERT --}}
                @if (session('success'))
                    <div class="swal-success" data-message="{{ session('success') }}"></div>
                @endif

                @if ($errors->any())
                    <div class="swal-error" data-message="{{ implode('<br>', $errors->all()) }}"></div>
                @endif

                {{-- KONTROL ATAS (Tabs & Search) --}}
                <div class="flex flex-col lg:flex-row justify-between items-center gap-4 mb-8">
                    <div
                        class="inline-flex rounded-xl shadow-sm bg-white dark:bg-gray-800 p-1.5 border dark:border-gray-700 w-full lg:w-auto">
                        <button id="show-list"
                            class="flex-1 lg:flex-none py-2 px-6 text-sm font-bold rounded-lg bg-yellow-500 text-white shadow-md transition-all">
                            Daftar Produk
                        </button>
                        <button id="show-form"
                            class="flex-1 lg:flex-none py-2 px-6 text-sm font-bold rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                            + Tambah Produk
                        </button>
                    </div>

                    <div class="flex flex-col md:flex-row items-center gap-3 w-full lg:w-auto">
                        <div class="relative w-full md:w-64">
                            <form action="{{ route('ManajemenMenu') }}" method="GET" id="search-form">
                                <input type="hidden" name="outlet_id" value="{{ request('outlet_id', 'all') }}">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari nama menu..."
                                    class="w-full pl-10 pr-4 py-2 text-sm border rounded-xl dark:bg-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-yellow-500 outline-none border-gray-200 dark:border-gray-700">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </form>
                        </div>

                        <select onchange="updateFilters(this.value)"
                            class="w-full md:w-auto pl-4 pr-10 py-2 text-sm font-bold bg-white dark:bg-gray-800 border rounded-xl dark:text-gray-200 border-gray-200 dark:border-gray-700 focus:ring-2 focus:ring-yellow-500 outline-none">
                            <option value="all">Semua Outlet</option>
                            @foreach ($outlets as $ot)
                                <option value="{{ $ot->id }}"
                                    {{ request('outlet_id') == $ot->id ? 'selected' : '' }}>
                                    {{ $ot->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- TABEL LIST PRODUK --}}
                <section id="list-view">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-x-auto border dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">
                                        Gambar</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">
                                        Nama & Deskripsi</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">
                                        Status</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">
                                        Outlet</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">
                                        Harga</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-widest">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($menus as $menu)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <img src="{{ asset('storage/' . $menu->image_url) }}"
                                                class="w-14 h-14 rounded-xl object-cover border border-gray-200 dark:border-gray-600 shadow-sm"
                                                onerror="this.src='https://via.placeholder.com/150'">
                                        </td>
                                        <td class="px-6 py-4 min-w-[200px]">
                                            <div class="font-bold dark:text-gray-100 text-lg">{{ $menu->name }}</div>
                                            <div class="text-xs text-gray-400 italic line-clamp-1">
                                                {{ $menu->description ?? 'Tanpa deskripsi' }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($menu->is_available)
                                                <span
                                                    class="px-3 py-1 bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 rounded-full text-[10px] font-black uppercase">Available</span>
                                            @else
                                                <span
                                                    class="px-3 py-1 bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 rounded-full text-[10px] font-black uppercase">Sold
                                                    Out</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-3 py-1 bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded-full text-[10px] font-black uppercase">{{ $menu->outlet->name }}</span>
                                        </td>
                                        <td
                                            class="px-6 py-4 font-bold text-yellow-600 dark:text-yellow-500 whitespace-nowrap">
                                            Rp {{ number_format($menu->price) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-center space-x-3">
                                                <button onclick='openEditModal(@json($menu))'
                                                    class="px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition-all text-xs font-bold uppercase">Edit</button>

                                                <form id="delete-form-{{ $menu->id }}"
                                                    action="{{ route('ManajemenMenu.destroy', $menu->id) }}"
                                                    method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="button" onclick="confirmDelete({{ $menu->id }})"
                                                        class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all text-xs font-bold uppercase">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 italic">Data
                                            menu tidak ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6 px-4">
                        <div class="dark:text-gray-300">
                            {{ $menus->appends(request()->query())->links() }}
                        </div>
                    </div>
                </section>

                {{-- FORM TAMBAH PRODUK (Hidden by Default) --}}
                <section id="form-view" class="hidden" x-data="{
                    menuType: 'makanan',
                    allowNote: false,
                    allowIceSugar: false,
                    allowEgg: false,
                    allowSpicy: false
                }">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 md:p-8 max-w-3xl mx-auto border dark:border-gray-700">
                        <h2 class="text-2xl font-bold dark:text-white mb-6">Tambah Menu Baru</h2>

                        <form action="{{ route('ManajemenMenu.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                {{-- Nama Produk --}}
                                <div>
                                    <label class="block text-sm font-bold dark:text-gray-300 mb-2">Nama Produk</label>
                                    <input type="text" name="name" required placeholder="Contoh: Es Kopi Susu"
                                        class="w-full px-4 py-2.5 border rounded-xl dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500 outline-none">
                                </div>

                                {{-- Tipe Menu (Kategori Utama) --}}
                                <div>
                                    <label class="block text-sm font-bold dark:text-gray-300 mb-2">Tipe Menu</label>
                                    <select name="type" x-model="menuType" required
                                        class="w-full px-4 py-2.5 border rounded-xl dark:bg-gray-700 dark:text-white outline-none focus:ring-2 focus:ring-yellow-500">
                                        <option value="makanan">Makanan</option>
                                        <option value="minuman">Minuman</option>
                                    </select>
                                </div>
                            </div>

                            {{-- OPSI KHUSUS MAKANAN --}}
                            <div x-show="menuType === 'makanan'" x-transition
                                class="mb-6 space-y-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-dashed border-gray-300 dark:border-gray-600">

                                {{-- Checkbox Catatan Kustom (Lama) --}}
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="checkbox" name="allow_custom_note" x-model="allowNote"
                                        value="1"
                                        class="w-5 h-5 text-yellow-500 border-gray-300 rounded focus:ring-yellow-500">
                                    <span class="text-sm font-bold dark:text-gray-200">Aktifkan Catatan Kustom</span>
                                </label>

                                {{-- Checkbox Opsi Telur (Baru) --}}
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="checkbox" name="allow_egg_option" x-model="allowEgg" value="1"
                                        class="w-5 h-5 text-yellow-500 border-gray-300 rounded focus:ring-yellow-500">
                                    <span class="text-sm font-bold dark:text-gray-200">Opsi Telur (Mateng / Set.
                                        Mateng)</span>
                                </label>

                                {{-- Checkbox Opsi Pedas (Baru) --}}
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="checkbox" name="allow_spicy_option" x-model="allowSpicy"
                                        value="1"
                                        class="w-5 h-5 text-yellow-500 border-gray-300 rounded focus:ring-yellow-500">
                                    <span class="text-sm font-bold dark:text-gray-200">Opsi Pedas (Pedas / Tidak
                                        Pedas)</span>
                                </label>

                                <p class="text-xs text-gray-500 mt-2">
                                    *Pilihan yang dicentang akan muncul sebagai opsi saat pelanggan memesan makanan ini.
                                </p>
                            </div>

                            {{-- OPSI KHUSUS MINUMAN --}}
                            <div x-show="menuType === 'minuman'" x-transition
                                class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800">

                                <label class="flex items-center space-x-3 cursor-pointer mb-2">
                                    <input type="checkbox" name="allow_ice_sugar_level" x-model="allowIceSugar"
                                        value="1"
                                        class="w-5 h-5 text-blue-500 border-gray-300 rounded focus:ring-blue-500">
                                    <span class="text-sm font-bold text-blue-800 dark:text-blue-300">Aktifkan Level Es
                                        & Gula</span>
                                </label>

                                <div class="flex items-start space-x-3 ml-8">
                                    <svg class="w-4 h-4 text-blue-500 mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-xs text-blue-600 dark:text-blue-400">
                                        Pelanggan dapat memilih: <b>Hot/Ice, Normal/Less Ice, dan Normal/Less Sugar</b>.
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                {{-- Harga --}}
                                <div>
                                    <label class="block text-sm font-bold dark:text-gray-300 mb-2">Harga (Rp)</label>
                                    <input type="number" name="price" required placeholder="25000"
                                        class="w-full px-4 py-2.5 border rounded-xl dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500 outline-none">
                                </div>

                                {{-- Status Stok --}}
                                <div>
                                    <label class="block text-sm font-bold dark:text-gray-300 mb-2">Status Stok</label>
                                    <select name="is_available" required
                                        class="w-full px-4 py-2.5 border rounded-xl dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500 outline-none">
                                        <option value="1">Available (Tersedia)</option>
                                        <option value="0">Sold Out (Habis)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                {{-- Outlet --}}
                                <div>
                                    <label class="block text-sm font-bold dark:text-gray-300 mb-2">Outlet</label>
                                    <select name="outlet_id" id="outlet_select" required
                                        class="w-full px-4 py-2.5 border rounded-xl dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500 outline-none">
                                        <option value="">-- Pilih Outlet --</option>
                                        @foreach ($outlets as $ot)
                                            <option value="{{ $ot->id }}">{{ $ot->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Kategori --}}
                                <div>
                                    <label class="block text-sm font-bold dark:text-gray-300 mb-2">Kategori</label>
                                    <select name="category_id" id="category_select" required
                                        class="w-full px-4 py-2.5 border rounded-xl dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500 outline-none">
                                        <option value="">-- Pilih Outlet Dahulu --</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="mb-6">
                                <label class="block text-sm font-bold dark:text-gray-300 mb-2">Deskripsi Produk</label>
                                <textarea name="description" rows="3" placeholder="Jelaskan komposisi atau rasa menu..."
                                    class="w-full px-4 py-2.5 border rounded-xl dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500 outline-none"></textarea>
                            </div>

                            {{-- Gambar Produk --}}
                            <div class="mb-8">
                                <label class="block text-sm font-bold dark:text-gray-300 mb-2">Gambar Produk</label>
                                <div
                                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl dark:border-gray-600 hover:border-yellow-500 transition-colors">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                            fill="none" viewBox="0 0 48 48">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                            <input type="file" name="image" required
                                                class="w-full cursor-pointer">
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, JPEG hingga 2MB</p>
                                    </div>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-black py-4 rounded-xl transition-all uppercase tracking-widest shadow-lg active:scale-95">
                                Simpan Produk Ke Menu
                            </button>
                        </form>
                    </div>
                </section>
            </div>
        </main>
    </div>

    {{-- MODAL EDIT PRODUK --}}
    <div id="editModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 py-6 text-center">
            <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm transition-opacity" onclick="closeEditModal()">
            </div>

            <div
                class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full border dark:border-gray-700 z-[101]">

                <form id="editForm" method="POST" enctype="multipart/form-data" class="p-6 md:p-8"
                    x-data="{ editMenuType: 'makanan' }">
                    @csrf @method('PUT')

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-black dark:text-white uppercase tracking-tighter">Edit Menu</h3>
                        <button type="button" onclick="closeEditModal()"
                            class="text-gray-400 hover:text-gray-600 text-xl">✕</button>
                    </div>

                    <div class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-black uppercase text-gray-400 mb-1">Nama
                                    Produk</label>
                                <input type="text" name="name" id="edit_name" required
                                    class="w-full px-4 py-2.5 border rounded-xl dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-black uppercase text-gray-400 mb-1">Tipe Menu</label>
                                <select name="type" id="edit_type" x-model="editMenuType" required
                                    class="w-full px-4 py-2.5 border rounded-xl dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500 outline-none">
                                    <option value="makanan">Makanan</option>
                                    <option value="minuman">Minuman</option>
                                </select>
                            </div>
                        </div>

                        {{-- OPSI DINAMIS EDIT - MAKANAN --}}
                        <div x-show="editMenuType === 'makanan'" x-transition
                            class="p-4 space-y-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-dashed border-gray-300">

                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="checkbox" name="allow_custom_note" id="edit_allow_custom_note"
                                    value="1"
                                    class="w-5 h-5 text-yellow-500 border-gray-300 rounded focus:ring-yellow-500">
                                <span class="text-xs font-bold dark:text-gray-200 uppercase">Aktifkan Catatan
                                    Kustom</span>
                            </label>

                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="checkbox" name="allow_egg_option" id="edit_allow_egg_option"
                                    value="1"
                                    class="w-5 h-5 text-yellow-500 border-gray-300 rounded focus:ring-yellow-500">
                                <span class="text-xs font-bold dark:text-gray-200 uppercase">Opsi Telur (Mateng/Set.
                                    Mateng)</span>
                            </label>

                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="checkbox" name="allow_spicy_option" id="edit_allow_spicy_option"
                                    value="1"
                                    class="w-5 h-5 text-yellow-500 border-gray-300 rounded focus:ring-yellow-500">
                                <span class="text-xs font-bold dark:text-gray-200 uppercase">Opsi Pedas
                                    (Ya/Tidak)</span>
                            </label>
                        </div>

                        {{-- OPSI DINAMIS EDIT - MINUMAN --}}
                        <div x-show="editMenuType === 'minuman'" x-transition
                            class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200">
                            <label class="flex items-center space-x-3 cursor-pointer">
                                <input type="checkbox" name="allow_ice_sugar_level" id="edit_allow_ice_sugar_level"
                                    value="1"
                                    class="w-5 h-5 text-blue-500 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-xs font-bold text-blue-800 dark:text-blue-300 uppercase">Opsi Ice &
                                    Sugar Level</span>
                            </label>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-black uppercase text-gray-400 mb-1">Harga (Rp)</label>
                                <input type="number" name="price" id="edit_price" required
                                    class="w-full px-4 py-2.5 border rounded-xl dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500 outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-black uppercase text-gray-400 mb-1">Status</label>
                                <select name="is_available" id="edit_is_available" required
                                    class="w-full px-4 py-2.5 border rounded-xl dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500 outline-none">
                                    <option value="1">Available</option>
                                    <option value="0">Sold Out</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-black uppercase text-gray-400 mb-1">Outlet</label>
                                <select name="outlet_id" id="edit_outlet_id" required
                                    class="w-full px-4 py-2.5 border rounded-xl dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500 outline-none">
                                    @foreach ($outlets as $ot)
                                        <option value="{{ $ot->id }}">{{ $ot->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-black uppercase text-gray-400 mb-1">Kategori</label>
                                <select name="category_id" id="edit_category_id" required
                                    class="w-full px-4 py-2.5 border rounded-xl dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500 outline-none"></select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase text-gray-400 mb-1">Deskripsi</label>
                            <textarea name="description" id="edit_description" rows="3"
                                class="w-full px-4 py-2.5 border rounded-xl dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-yellow-500 outline-none"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase text-gray-400 mb-1">Ganti Gambar
                                (Opsional)</label>
                            <input type="file" name="image"
                                class="w-full text-sm dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-yellow-50 file:text-yellow-700">
                        </div>
                    </div>

                    <div class="mt-8 flex gap-3">
                        <button type="button" onclick="closeEditModal()"
                            class="flex-1 py-3 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-bold rounded-xl hover:bg-gray-200 transition-all">Batal</button>
                        <button type="submit"
                            class="flex-1 py-3 bg-yellow-500 text-white font-black rounded-xl hover:bg-yellow-600 shadow-lg transition-all uppercase tracking-widest">Update
                            Menu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('layouts.JsAdmin')

    <script>
        // --- MODAL EDIT & DELETE LOGIC ---
        window.closeEditModal = function() {
            const modal = document.getElementById('editModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        };

        window.updateFilters = function(outletId) {
            const url = new URL(window.location.href);
            url.searchParams.set('outlet_id', outletId);
            url.searchParams.delete('page');
            window.location.href = url.href;
        };

        window.confirmDelete = function(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data menu ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        };

        document.addEventListener('DOMContentLoaded', function() {
            const editOutletSelect = document.getElementById('edit_outlet_id');
            if (editOutletSelect) {
                editOutletSelect.addEventListener('change', async function() {
                    // Memanggil fungsi pembantu loadCategories yang sudah Anda buat
                    await loadCategoriesForEdit(this.value);
                });
            }
            // --- Notifikasi SweetAlert ---
            const successEl = document.querySelector('.swal-success');
            if (successEl) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: successEl.dataset.message,
                    timer: 3000,
                    showConfirmButton: false
                });
            }
            const errorEl = document.querySelector('.swal-error');
            if (errorEl) {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    html: errorEl.dataset.message,
                    confirmButtonColor: '#EAB308'
                });
            }

            // --- Tab Switcher (List vs Add Form) ---
            const listBtn = document.getElementById('show-list');
            const formBtn = document.getElementById('show-form');
            const listView = document.getElementById('list-view');
            const formView = document.getElementById('form-view');

            if (listBtn && formBtn) {
                listBtn.addEventListener('click', () => {
                    listView.classList.remove('hidden');
                    formView.classList.add('hidden');
                    listBtn.className =
                        'flex-1 lg:flex-none py-2 px-6 text-sm font-bold rounded-lg bg-yellow-500 text-white shadow-md transition-all';
                    formBtn.className =
                        'flex-1 lg:flex-none py-2 px-6 text-sm font-bold rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all';
                });
                formBtn.addEventListener('click', () => {
                    listView.classList.add('hidden');
                    formView.classList.remove('hidden');
                    formBtn.className =
                        'flex-1 lg:flex-none py-2 px-6 text-sm font-bold rounded-lg bg-yellow-500 text-white shadow-md transition-all';
                    listBtn.className =
                        'flex-1 lg:flex-none py-2 px-6 text-sm font-bold rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all';
                });
            }

            // --- Dynamic Categories for Add Form ---
            const outletSelect = document.getElementById('outlet_select');
            if (outletSelect) {
                outletSelect.addEventListener('change', async function() {
                    const selectKategori = document.getElementById('category_select');
                    const outletId = this.value;
                    if (!outletId) {
                        selectKategori.innerHTML =
                            '<option value="">-- Pilih Outlet Dahulu --</option>';
                        return;
                    }
                    selectKategori.innerHTML = '<option value="">Memuat...</option>';
                    try {
                        const res = await fetch(`/get-categories/${outletId}`);
                        const data = await res.json();
                        selectKategori.innerHTML = '<option value="">-- Pilih Kategori --</option>';
                        data.forEach(cat => {
                            selectKategori.innerHTML +=
                                `<option value="${cat.id}">${cat.name}</option>`;
                        });
                    } catch (e) {
                        selectKategori.innerHTML = '<option value="">Gagal memuat</option>';
                    }
                });
            }
        });

        // --- EDIT MODAL AJAX LOGIC (SINKRONISASI OTOMATIS) ---
        async function openEditModal(menu) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');

            // 1. Set Action URL (Gunakan route tanpa strip jika di controller manajemenmenu)
            form.action = `/manajemenmenu/${menu.id}`;

            // 2. Set Value Input Utama
            document.getElementById('edit_name').value = menu.name;
            document.getElementById('edit_price').value = Math.floor(menu.price);
            document.getElementById('edit_description').value = menu.description || '';
            document.getElementById('edit_is_available').value = menu.is_available;
            document.getElementById('edit_outlet_id').value = menu.outlet_id;
            document.getElementById('edit_type').value = menu.type;

            // 3. PENTING: PAKSA ALPINE.JS UPDATE STATE
            // Bagian ini yang membuat x-show langsung sembunyi/muncul sesuai tipe
            if (window.Alpine) {
                // Mencari data scope Alpine pada form edit
                const alpineData = Alpine.$data(form);
                if (alpineData) {
                    alpineData.editMenuType = menu.type;
                }
            }

            // 4. SET CHECKBOX VALUES
            const setCheck = (id, val) => {
                const el = document.getElementById(id);
                if (el) el.checked = (val == 1 || val == true);
            };

            setCheck('edit_allow_custom_note', menu.allow_custom_note);
            setCheck('edit_allow_egg_option', menu.allow_egg_option);
            setCheck('edit_allow_spicy_option', menu.allow_spicy_option);
            setCheck('edit_allow_ice_sugar_level', menu.allow_ice_sugar_level);

            // 5. Load Kategori
            await loadCategoriesForEdit(menu.outlet_id, menu.category_id);

            // 6. Tampilkan Modal
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        async function loadCategoriesForEdit(outletId, selectedCategoryId = null) {
            const catSelect = document.getElementById('edit_category_id');
            if (!catSelect) return;

            if (!outletId) {
                catSelect.innerHTML = '<option value="">-- Pilih Outlet Dahulu --</option>';
                return;
            }

            catSelect.innerHTML = '<option value="">Memuat...</option>';
            try {
                const res = await fetch(`/get-categories/${outletId}`);
                const data = await res.json();

                catSelect.innerHTML = '<option value="">-- Pilih Kategori --</option>';
                data.forEach(cat => {
                    const selected = (selectedCategoryId && cat.id == selectedCategoryId) ? 'selected' : '';
                    catSelect.innerHTML += `<option value="${cat.id}" ${selected}>${cat.name}</option>`;
                });
            } catch (e) {
                catSelect.innerHTML = '<option value="">Gagal memuat kategori</option>';
                console.error("Error fetching categories:", e);
            }
        }
    </script>
</body>

</html>
