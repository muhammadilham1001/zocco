<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: false }">

@include('layouts.HeadAdmin')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- Tambahkan Alpine.js jika belum ada di HeadAdmin --}}
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-500 font-poppins overflow-hidden">

    <div class="flex h-screen overflow-hidden">

        {{-- SIDEBAR CONTAINER (Hanya satu kali pemanggilan) --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-[200] w-64 bg-gray-950 shadow-2xl transition-transform duration-300 ease-in-out lg:relative lg:translate-x-0 lg:flex flex-shrink-0 border-r border-gray-800">
            @include('layouts.SidebarAdmin')
        </aside>

        {{-- Overlay untuk Mobile --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            class="fixed inset-0 z-[190] bg-black/60 backdrop-blur-sm lg:hidden" x-transition:opacity></div>

        {{-- MAIN CONTENT AREA --}}
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden relative">
            <div class="flex-1 p-4 md:p-8 overflow-y-auto">

                {{-- Header responsif --}}
                <header class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
                    <div class="flex items-center gap-4">
                        {{-- Tombol Hamburger Mobile --}}
                        <button @click="sidebarOpen = true"
                            class="lg:hidden p-2 rounded-xl bg-white dark:bg-gray-800 shadow-sm border dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-6 h-6 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <h1
                            class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100 uppercase tracking-tight">
                            Kategori Produk
                        </h1>
                    </div>
                </header>

                {{-- Notifikasi --}}
                @if (session('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: "{{ session('success') }}",
                            showConfirmButton: false,
                            timer: 2000,
                            customClass: {
                                popup: 'rounded-2xl shadow-xl'
                            }
                        });
                    </script>
                @endif

                {{-- Control Bar --}}
                <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-4 mb-8">
                    <div class="flex flex-col md:flex-row gap-3 w-full lg:w-auto">
                        <div class="relative w-full">
                            <input type="text" id="search-input" onkeyup="filterTable()"
                                placeholder="Cari kategori..."
                                class="pl-10 pr-4 py-2.5 border rounded-xl dark:bg-gray-800 dark:text-white dark:border-gray-700 focus:ring-2 focus:ring-yellow-500 outline-none w-full md:w-64 text-sm">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>

                        <select id="filter-outlet" onchange="filterTable()"
                            class="px-4 py-2.5 border rounded-xl dark:bg-gray-800 dark:text-white dark:border-gray-700 focus:ring-2 focus:ring-yellow-500 outline-none text-sm cursor-pointer">
                            <option value="all">Semua Outlet</option>
                            @foreach ($outlets as $outlet)
                                <option value="{{ $outlet->name }}">{{ $outlet->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div
                        class="inline-flex rounded-xl shadow-sm bg-white dark:bg-gray-800 p-1 border dark:border-gray-700 w-full sm:w-auto">
                        <button id="show-list"
                            class="flex-1 sm:flex-none py-2 px-4 md:px-6 text-xs md:text-sm font-bold rounded-lg transition-all bg-yellow-500 text-white shadow-md">
                            Daftar Kategori
                        </button>
                        <button id="show-form"
                            class="flex-1 sm:flex-none py-2 px-4 md:px-6 text-xs md:text-sm font-bold rounded-lg transition-all text-gray-600 dark:text-gray-300">
                            + Tambah Baru
                        </button>
                    </div>
                </div>

                {{-- View Sections --}}
                <section id="list-view">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border dark:border-gray-700">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" id="category-table">
                                <thead class="bg-gray-50 dark:bg-gray-700/50">
                                    <tr>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                                            Nama Kategori</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                                            Outlet</th>
                                        <th
                                            class="px-6 py-4 text-center text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse ($categories as $category)
                                        <tr class="category-row hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors"
                                            data-outlet="{{ $category->outlet->name ?? '' }}">
                                            <td
                                                class="px-6 py-4 dark:text-gray-100 font-semibold text-sm category-name">
                                                {{ $category->name }}</td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-300">
                                                    {{ $category->outlet->name ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="flex items-center justify-center space-x-3">
                                                    <button
                                                        onclick="openEditCategoryModal('{{ $category->id }}', '{{ $category->name }}', '{{ $category->outlet_id }}')"
                                                        class="text-indigo-600 font-bold text-sm hover:underline dark:text-indigo-400 uppercase">Edit</button>
                                                    <form id="delete-form-{{ $category->id }}"
                                                        action="{{ route('ManajemenKategori.destroy', $category->id) }}"
                                                        method="POST" class="inline">
                                                        @csrf @method('DELETE')
                                                        <button type="button"
                                                            onclick="confirmDelete('{{ $category->id }}')"
                                                            class="text-red-600 font-bold text-sm hover:underline dark:text-red-400 uppercase">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-12 text-center text-gray-500 italic">Data
                                                kosong.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <section id="form-view" class="hidden">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 md:p-10 max-w-lg mx-auto border dark:border-gray-700">
                        <h2 class="text-xl md:text-2xl font-black mb-8 dark:text-white uppercase text-center">Tambah
                            Kategori</h2>
                        <form action="{{ route('ManajemenKategori.store') }}" method="POST" class="space-y-5">
                            @csrf
                            <div>
                                <label class="block text-xs font-black uppercase text-gray-500 mb-2">Pilih
                                    Outlet</label>
                                <select name="outlet_id" required
                                    class="w-full px-4 py-3 border rounded-xl dark:bg-gray-700 dark:text-white outline-none focus:ring-2 focus:ring-yellow-500">
                                    <option value="">-- Pilih --</option>
                                    @foreach ($outlets as $outlet)
                                        <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-black uppercase text-gray-500 mb-2">Nama
                                    Kategori</label>
                                <input type="text" name="name" placeholder="Kategori" required
                                    class="w-full px-4 py-3 border rounded-xl dark:bg-gray-700 dark:text-white outline-none focus:ring-2 focus:ring-yellow-500">
                            </div>
                            <button type="submit"
                                class="w-full bg-yellow-500 text-white font-black py-4 rounded-xl uppercase shadow-lg hover:bg-yellow-600 transition-colors">Simpan</button>
                        </form>
                    </div>
                </section>
            </div>
        </main>
    </div>

    {{-- Edit Modal --}}
    <div id="editModal" class="fixed inset-0 z-[210] hidden flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" onclick="closeEditModal()"></div>
        <div class="relative bg-white dark:bg-gray-800 p-6 rounded-2xl w-full max-w-md shadow-2xl">
            <h3 class="text-xl font-black mb-6 dark:text-white uppercase">Edit Kategori</h3>
            <form id="editForm" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-xs font-black uppercase text-gray-500 mb-2">Outlet</label>
                    <select id="edit_outlet_id" name="outlet_id"
                        class="w-full px-4 py-2.5 border rounded-xl dark:bg-gray-700 dark:text-white outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach ($outlets as $outlet)
                            <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-black uppercase text-gray-500 mb-2">Nama Kategori</label>
                    <input type="text" id="edit_name" name="name"
                        class="w-full px-4 py-2.5 border rounded-xl dark:bg-gray-700 dark:text-white outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeEditModal()"
                        class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 dark:text-white rounded-xl font-bold hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">Batal</button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold uppercase hover:bg-indigo-700 transition-colors">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Konfirmasi Hapus SweetAlert
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data kategori ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#eab308',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-2xl'
                }
            }).then((result) => {
                if (result.isConfirmed) document.getElementById('delete-form-' + id).submit();
            })
        }

        // Fitur Filter dan Search
        function filterTable() {
            const searchQuery = document.getElementById('search-input').value.toLowerCase();
            const filterOutlet = document.getElementById('filter-outlet').value;
            const rows = document.querySelectorAll('.category-row');

            rows.forEach(row => {
                const name = row.querySelector('.category-name').textContent.toLowerCase();
                const outlet = row.getAttribute('data-outlet');
                const matchesSearch = name.includes(searchQuery);
                const matchesOutlet = (filterOutlet === 'all' || outlet === filterOutlet);
                row.style.display = (matchesSearch && matchesOutlet) ? '' : 'none';
            });
        }

        // Toggle View List vs Form
        const showList = document.getElementById('show-list');
        const showForm = document.getElementById('show-form');
        const listView = document.getElementById('list-view');
        const formView = document.getElementById('form-view');

        showList.onclick = () => {
            listView.classList.remove('hidden');
            formView.classList.add('hidden');
            showList.className =
                "flex-1 sm:flex-none py-2 px-4 md:px-6 text-xs md:text-sm font-bold rounded-lg bg-yellow-500 text-white shadow-md transition-all";
            showForm.className =
                "flex-1 sm:flex-none py-2 px-4 md:px-6 text-xs md:text-sm font-bold rounded-lg text-gray-600 dark:text-gray-300 transition-all";
        }

        showForm.onclick = () => {
            listView.classList.add('hidden');
            formView.classList.remove('hidden');
            showForm.className =
                "flex-1 sm:flex-none py-2 px-4 md:px-6 text-xs md:text-sm font-bold rounded-lg bg-yellow-500 text-white shadow-md transition-all";
            showList.className =
                "flex-1 sm:flex-none py-2 px-4 md:px-6 text-xs md:text-sm font-bold rounded-lg text-gray-600 dark:text-gray-300 transition-all";
        }

        // Modal Edit
        function openEditCategoryModal(id, name, outletId) {
            document.getElementById('editForm').action = `/ManajemenKategori/${id}`;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_outlet_id').value = outletId;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") {
                closeEditModal();
            }
        });
    </script>
</body>

</html>
