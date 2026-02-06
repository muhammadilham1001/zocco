<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: false }">

<head>
    @include('layouts.HeadAdmin')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Alpine.js untuk handling toggle sidebar --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-500 font-poppins overflow-hidden">

    <div class="flex h-screen overflow-hidden">

        {{-- SIDEBAR CONTAINER --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-[200] w-64 bg-gray-950 shadow-2xl transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 flex-shrink-0 border-r border-gray-800">
            @include('layouts.SidebarAdmin')
        </aside>

        {{-- Overlay untuk Mobile --}}
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
            class="fixed inset-0 z-[190] bg-black/60 backdrop-blur-sm lg:hidden"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        </div>

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
                        {{-- Judul di sebelah toggle --}}
                        <h1
                            class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100 uppercase tracking-tight">
                            Manajemen Dashboard
                        </h1>
                    </div>
                </header>

                {{-- Notifikasi --}}
                @if (session('success'))
                    <div class="swal-success-trigger" data-message="{{ session('success') }}"></div>
                @endif

                @if ($errors->any())
                    <div class="swal-error-trigger" data-message="{{ implode('<br>', $errors->all()) }}"></div>
                @endif

                {{-- Control Bar --}}
                <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-4 mb-8">
                    <div
                        class="inline-flex rounded-xl shadow-sm bg-white dark:bg-gray-800 p-1 border dark:border-gray-700 w-full sm:w-auto">
                        <button id="show-foto"
                            class="flex-1 sm:flex-none py-2 px-4 md:px-6 text-xs md:text-sm font-bold rounded-lg transition-all bg-yellow-500 text-white shadow-md">
                            Galeri Foto
                        </button>
                        <button id="show-teks"
                            class="flex-1 sm:flex-none py-2 px-4 md:px-6 text-xs md:text-sm font-bold rounded-lg transition-all text-gray-600 dark:text-gray-300">
                            Teks & Promosi
                        </button>
                    </div>
                </div>

                {{-- SECTION GALERI FOTO --}}
                <section id="foto-view">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border dark:border-gray-700 p-4 md:p-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                            <h2 class="text-xl font-black dark:text-white uppercase">Daftar Foto Galeri</h2>
                            <button id="tambah-foto-btn"
                                class="w-full sm:w-auto px-4 py-2 text-sm font-bold rounded-xl bg-yellow-500 text-white hover:bg-yellow-600 transition-all shadow-md">
                                + Tambah Foto Baru
                            </button>
                        </div>

                        {{-- Form Tambah Foto --}}
                        <div id="form-foto"
                            class="mb-8 p-6 border border-gray-100 dark:border-gray-700 rounded-2xl hidden bg-gray-50 dark:bg-gray-700/30">
                            <form action="{{ route('admin.foto.store') }}" method="POST" enctype="multipart/form-data"
                                class="space-y-4">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-black uppercase text-gray-500 mb-2">Judul
                                            Foto</label>
                                        <input type="text" name="judul" required
                                            class="w-full px-4 py-2.5 border rounded-xl dark:bg-gray-800 dark:text-white dark:border-gray-600 outline-none focus:ring-2 focus:ring-yellow-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-black uppercase text-gray-500 mb-2">File
                                            Gambar</label>
                                        <input type="file" name="file_foto" required
                                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <button type="submit"
                                        class="px-6 py-2 bg-green-600 text-white rounded-xl font-bold hover:bg-green-700 transition-all">Simpan</button>
                                    <button type="button" id="batal-foto-btn"
                                        class="px-6 py-2 bg-gray-500 text-white rounded-xl font-bold hover:bg-gray-600 transition-all">Batal</button>
                                </div>
                            </form>
                        </div>

                        <div class="overflow-x-auto rounded-xl border dark:border-gray-700">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700/50">
                                    <tr>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                                            Gambar</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                                            Judul</th>
                                        <th
                                            class="px-6 py-4 text-center text-xs font-black text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($galleries as $foto)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                            <td class="px-6 py-4">
                                                <img src="{{ asset('storage/' . $foto->image_path) }}"
                                                    class="w-20 h-14 object-cover rounded-lg shadow-sm border dark:border-gray-600">
                                            </td>
                                            <td class="px-6 py-4 dark:text-gray-100 font-semibold text-sm">
                                                {{ $foto->judul }}</td>
                                            <td class="px-6 py-4 text-center">
                                                <button type="button"
                                                    onclick="confirmDeleteFoto('{{ route('admin.foto.delete', $foto->id) }}')"
                                                    class="text-red-600 font-bold text-sm hover:underline dark:text-red-400 uppercase">Hapus</button>
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

                {{-- SECTION TEKS & PROMOSI --}}
                <section id="teks-view" class="hidden">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 md:p-10 max-w-3xl mx-auto border dark:border-gray-700">
                        <h2 class="text-xl md:text-2xl font-black mb-8 dark:text-white uppercase text-center">Update
                            Teks & Promosi</h2>

                        {{-- Ditambahkan enctype untuk upload gambar --}}
                        <form action="{{ route('admin.text.update') }}" method="POST" enctype="multipart/form-data"
                            class="space-y-6">
                            @csrf

                            {{-- Input Slogan --}}
                            <div>
                                <label class="block text-xs font-black uppercase text-gray-500 mb-2">Slogan
                                    Utama</label>
                                <textarea name="slogan" rows="2" required
                                    class="w-full px-4 py-3 border rounded-xl dark:bg-gray-700 dark:text-white outline-none focus:ring-2 focus:ring-yellow-500 shadow-sm">{{ $slogan->value ?? '' }}</textarea>
                            </div>

                            {{-- Input Deskripsi --}}
                            <div>
                                <label class="block text-xs font-black uppercase text-gray-500 mb-2">Deskripsi</label>
                                <textarea name="deskripsi" rows="4" required
                                    class="w-full px-4 py-3 border rounded-xl dark:bg-gray-700 dark:text-white outline-none focus:ring-2 focus:ring-yellow-500 shadow-sm">{{ $deskripsi->value ?? '' }}</textarea>
                            </div>

                            {{-- INPUT GAMBAR BARU (Sesuai kolom 'image' di tabel settings) --}}
                            <div class="p-4 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-2xl">
                                <label class="block text-xs font-black uppercase text-gray-500 mb-3">Gambar Promosi /
                                    Latar</label>

                                @if (isset($slogan->image))
                                    <div class="mb-4">
                                        <p class="text-[10px] text-gray-400 uppercase mb-1">Preview Saat Ini:</p>
                                        <img src="{{ asset('storage/' . $slogan->image) }}"
                                            class="w-32 h-20 object-cover rounded-lg border dark:border-gray-600">
                                    </div>
                                @endif

                                <input type="file" name="image_setting"
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
                                <p class="mt-2 text-[10px] text-gray-400">*Kosongkan jika tidak ingin mengubah gambar.
                                </p>
                            </div>

                            <button type="submit"
                                class="w-full bg-yellow-500 text-white font-black py-4 rounded-xl uppercase shadow-lg hover:bg-yellow-600 transition-all active:scale-95">
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </section>
            </div>
        </main>
    </div>

    @include('layouts.JsAdmin')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Notifikasi handling (SweetAlert)
            const successEl = document.querySelector('.swal-success-trigger');
            if (successEl) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: successEl.dataset.message,
                    timer: 3000,
                    showConfirmButton: false
                });
            }

            const errorEl = document.querySelector('.swal-error-trigger');
            if (errorEl) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    html: errorEl.dataset.message
                });
            }

            // Toggle Antar View
            const showFoto = document.getElementById('show-foto');
            const showTeks = document.getElementById('show-teks');
            const fotoView = document.getElementById('foto-view');
            const teksView = document.getElementById('teks-view');

            if (showFoto && showTeks) {
                showFoto.onclick = () => {
                    fotoView.classList.remove('hidden');
                    teksView.classList.add('hidden');
                    showFoto.className =
                        "flex-1 sm:flex-none py-2 px-4 md:px-6 text-xs md:text-sm font-bold rounded-lg bg-yellow-500 text-white shadow-md transition-all";
                    showTeks.className =
                        "flex-1 sm:flex-none py-2 px-4 md:px-6 text-xs md:text-sm font-bold rounded-lg text-gray-600 dark:text-gray-300 transition-all";
                }

                showTeks.onclick = () => {
                    teksView.classList.remove('hidden');
                    fotoView.classList.add('hidden');
                    showTeks.className =
                        "flex-1 sm:flex-none py-2 px-4 md:px-6 text-xs md:text-sm font-bold rounded-lg bg-yellow-500 text-white shadow-md transition-all";
                    showFoto.className =
                        "flex-1 sm:flex-none py-2 px-4 md:px-6 text-xs md:text-sm font-bold rounded-lg text-gray-600 dark:text-gray-300 transition-all";
                }
            }

            // Toggle Form Tambah Foto
            const tBtn = document.getElementById('tambah-foto-btn');
            const fFoto = document.getElementById('form-foto');
            const bBtn = document.getElementById('batal-foto-btn');

            if (tBtn) {
                tBtn.onclick = () => {
                    fFoto.classList.toggle('hidden');
                    tBtn.classList.add('hidden');
                };
            }
            if (bBtn) {
                bBtn.onclick = () => {
                    fFoto.classList.add('hidden');
                    tBtn.classList.remove('hidden');
                };
            }
        });

        // Konfirmasi Hapus Foto
        function confirmDeleteFoto(url) {
            Swal.fire({
                title: 'Hapus Foto?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#eab308',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.createElement('form');
                    form.action = url;
                    form.method = 'POST';
                    form.innerHTML = `
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            })
        }
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</body>

</html>
