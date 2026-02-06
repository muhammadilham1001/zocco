<!DOCTYPE html>
<html lang="id">

@include('layouts.HeadAdmin')
<style>
    [x-cloak] {
        display: none !important;
    }

    /* Menghindari teks meluber di layar kecil */
    .truncate-custom {
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-500 ease-in-out font-poppins" x-data="{
    sidebarOpen: false,
    showModal: false,
    editMode: false,
    actionUrl: '',
    searchQuery: '',

    // Data Outlet dari Backend
    outlets: {{ Js::from($outlets->items()) }},
    formData: { id: '', name: '', address: '', phone: '', email: '', city: '' , wa: '', ig: '', tt: '' },

    // Pencarian Dinamis (Client-side)
    get filteredOutlets() {
        if (this.searchQuery === '') return this.outlets;
        return this.outlets.filter(outlet => {
            return outlet.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                outlet.city.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                (outlet.email && outlet.email.toLowerCase().includes(this.searchQuery.toLowerCase()));
        });
    },

    openAdd() {
        this.editMode = false;
        this.formData = { id: '', name: '', address: '', phone: '', email: '', city: '', wa: '', ig: '', tt: '' };
        this.actionUrl = '{{ route('Manajemenoutlet.store') }}';
        this.showModal = true;
    },

    openEdit(outlet) {
        this.editMode = true;
        this.formData = { ...outlet };
        this.actionUrl = '{{ url('Manajemenoutlet') }}/' + outlet.id; // Perbaikan URL agar konsisten
        this.showModal = true;
    },

    confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data outlet ini akan dihapus permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
}"
    x-init="$nextTick(() => {
        @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: {{ Js::from(session('success')) }}, showConfirmButton: false, timer: 3000 });
        @endif
    })">

    <div class="flex h-screen overflow-hidden">
        {{-- SIDEBAR --}}
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 transition-transform duration-300 transform md:relative md:translate-x-0 border-r dark:border-gray-700">
            @include('layouts.SidebarAdmin')
        </div>

        {{-- OVERLAY MOBILE --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/50 md:hidden"
            x-transition:enter="transition opacity-ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition opacity-ease-in duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>
        </div>

        <main class="flex-1 overflow-y-auto p-4 md:p-8">

            {{-- HEADER DENGAN TOGGLE HAMBURGER INTEGRATED --}}
            <header class="flex flex-col md:flex-row items-start md:items-center justify-between mb-8 gap-4">
                <div class="flex items-center gap-4">
                    {{-- TOMBOL HAMBURGER (Hanya muncul di Mobile) --}}
                    <button @click="sidebarOpen = true"
                        class="md:hidden p-2 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 border dark:border-gray-700 rounded-lg shadow-sm focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100">Manajemen Outlet
                        </h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 hidden sm:block">Kelola data cabang dan
                            operasional outlet Anda.</p>
                    </div>
                </div>

            </header>

            {{-- SEARCH & ACTION --}}
            <div
                class="mb-6 flex flex-col lg:flex-row gap-4 lg:items-center justify-between bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="relative w-full lg:w-1/3">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input x-model="searchQuery" type="text" placeholder="Cari nama, kota, atau email..."
                        class="w-full bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-yellow-500 outline-none transition-all">
                </div>

                <button @click="openAdd()"
                    class="px-5 py-2.5 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 font-bold whitespace-nowrap shadow-md flex items-center justify-center gap-2 transition-all transform hover:scale-[1.02]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Outlet
                </button>
            </div>

            {{-- TABLE SECTION --}}
            <section class="transition-all duration-300">
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr
                                    class="text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    <th class="px-6 py-4 w-24">Media</th>
                                    <th class="px-6 py-4">Informasi Outlet</th>
                                    <th class="px-6 py-4 hidden md:table-cell">Kontak</th>
                                    <th class="px-6 py-4 hidden lg:table-cell w-1/3">Alamat / Kota</th>
                                    <th class="px-6 py-4 text-center w-40">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                                <template x-for="outlet in filteredOutlets" :key="outlet.id">
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors group">
                                        {{-- Kolom Foto & Logo Gabung --}}
                                        <td class="px-6 py-4">
                                            <div class="relative flex items-center">
                                                <template x-if="outlet.image">
                                                    <img :src="'/storage/' + outlet.image"
                                                        class="w-12 h-12 object-cover rounded-xl border-2 border-white dark:border-gray-800 shadow-md">
                                                </template>
                                                <template x-if="outlet.logo">
                                                    <div class="absolute -bottom-1 -right-1">
                                                        <img :src="'/storage/' + outlet.logo"
                                                            class="w-6 h-6 object-contain rounded-md bg-white p-0.5 border shadow-sm">
                                                    </div>
                                                </template>
                                            </div>
                                        </td>

                                        {{-- Informasi Utama --}}
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-yellow-600 transition-colors"
                                                x-text="outlet.name"></div>
                                            <div class="text-[10px] text-gray-400 uppercase mt-0.5 tracking-tight lg:hidden"
                                                x-text="outlet.city"></div>
                                        </td>

                                        {{-- Email --}}
                                        <td class="px-6 py-4 hidden md:table-cell">
                                            <div
                                                class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                                <span x-text="outlet.email || '-'"></span>
                                            </div>
                                        </td>

                                        {{-- Kota/Alamat --}}
                                        <td class="px-6 py-4 hidden lg:table-cell">
                                            <div class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed italic line-clamp-2"
                                                x-text="outlet.city"></div>
                                        </td>

                                        {{-- Tombol Aksi --}}
                                        <td class="px-6 py-4">
                                            <div class="flex justify-center items-center gap-2">
                                                <button @click="openEdit(outlet)"
                                                    class="p-2 text-indigo-600 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                </button>

                                                <form :id="'delete-form-' + outlet.id"
                                                    :action="'/outlets/destroy/' + outlet.id" method="POST"
                                                    class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="button" @click="confirmDelete(outlet.id)"
                                                        class="p-2 text-red-600 bg-red-50 dark:bg-red-900/30 rounded-lg hover:bg-red-600 hover:text-white transition-all shadow-sm">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                </template>

                                {{-- Empty State --}}
                                <template x-if="filteredOutlets.length === 0">
                                    <tr>
                                        <td colspan="5" class="px-6 py-16 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-full mb-4">
                                                    <svg class="w-12 h-12 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                                                            stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                </div>
                                                <span class="text-gray-500 dark:text-gray-400 font-medium">Belum ada
                                                    data outlet yang cocok.</span>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION --}}
                    <div
                        class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-200 dark:border-gray-700">
                        {{ $outlets->links() }}
                    </div>
                </div>
            </section>
        </main>
    </div>

    {{-- MODAL OUTLET --}}
    <div x-show="showModal" class="fixed inset-0 z-[100] overflow-y-auto" x-cloak
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">

        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-black/75 backdrop-blur-sm" @click="showModal = false"></div>

            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-lg p-6 md:p-8 z-[110] border dark:border-gray-700 relative">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight"
                        x-text="editMode ? 'Edit Data Outlet' : 'Tambah Outlet Baru'"></h3>
                    <button @click="showModal = false"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form :action="actionUrl" method="POST" enctype="multipart/form-data">
                    @csrf
                    <template x-if="editMode">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="space-y-5">
                        <div>
                            <label class="text-xs font-black uppercase text-gray-400 mb-1.5 block tracking-wider">Nama
                                Outlet</label>
                            <input type="text" name="name" x-model="formData.name"
                                placeholder="Zocco Coffee Sudirman"
                                class="w-full bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl p-3 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-yellow-500 outline-none transition-all"
                                required>
                        </div>

                        <div>
                            <label
                                class="text-xs font-black uppercase text-gray-400 mb-1.5 block tracking-wider">Email</label>
                            <input type="email" name="email" x-model="formData.email"
                                placeholder="outlet@zocco.id"
                                class="w-full bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl p-3 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-yellow-500 outline-none transition-all"
                                required>
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase text-gray-400 mb-1 block">WhatsApp</label>
                            <input type="text" name="wa" x-model="formData.wa" placeholder="628..."
                                class="w-full bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg p-2 text-sm border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-yellow-500 outline-none">
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase text-gray-400 mb-1 block">Instagram</label>
                            <input type="text" name="ig" x-model="formData.ig" placeholder="@username"
                                class="w-full bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg p-2 text-sm border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-yellow-500 outline-none">
                        </div>
                        <div>
                            <label class="text-[10px] font-black uppercase text-gray-400 mb-1 block">TikTok</label>
                            <input type="text" name="tt" x-model="formData.tt" placeholder="@username"
                                class="w-full bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg p-2 text-sm border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-yellow-500 outline-none">
                        </div>
                        <div>
                            <label class="text-xs font-black uppercase text-gray-400 mb-1.5 block tracking-wider">Kota
                                / Alamat</label>
                            <textarea name="city" x-model="formData.city" rows="3"
                                placeholder="Jl. Villa Puncak Tidar, Lowokwaru, Kota Malang"
                                class="w-full bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl p-3 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-yellow-500 outline-none transition-all resize-none"
                                required></textarea>
                        </div>

                        <div
                            class="grid grid-cols-2 gap-4 bg-gray-50 dark:bg-gray-700/50 p-4 rounded-xl border border-dashed border-gray-300 dark:border-gray-600">
                            <div>
                                <label
                                    class="text-[10px] font-black uppercase text-yellow-600 dark:text-yellow-500 mb-2 block tracking-widest">Foto
                                    Gedung</label>
                                <input type="file" name="image"
                                    class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-yellow-600 file:text-white hover:file:bg-yellow-700 cursor-pointer">
                            </div>
                            <div>
                                <label
                                    class="text-[10px] font-black uppercase text-yellow-600 dark:text-yellow-500 mb-2 block tracking-widest">Logo
                                    Cabang</label>
                                <input type="file" name="logo"
                                    class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-[10px] file:font-bold file:bg-yellow-600 file:text-white hover:file:bg-yellow-700 cursor-pointer">
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex gap-3">
                        <button type="button" @click="showModal = false"
                            class="flex-1 py-3 text-gray-500 dark:text-gray-400 font-bold hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all uppercase text-sm tracking-widest">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 py-3 bg-yellow-600 text-white rounded-xl font-black shadow-lg hover:bg-yellow-700 transition-all uppercase text-sm tracking-[0.2em]">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @include('layouts.JsAdmin')
</body>

</html>
