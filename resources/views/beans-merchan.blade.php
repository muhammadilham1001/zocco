<!DOCTYPE html>
<html lang="id">
@include('layouts.HeadAdmin')
<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-500 ease-in-out font-poppins" x-data="{
    activeTab: 'beans',
    showModalBean: false,
    showModalMerch: false,
    editMode: false,
    actionUrl: '',
    searchQuery: '',
    filterOutlet: '',
    sidebarOpen: false,

    beans: {{ Js::from($beans->items()) }},
    merchandises: {{ Js::from($merchandises->items()) }},

    formData: { id: '', name: '', origin: '', price: '', stock: '', category: '', image_path: '', outlet_id: '' },

    get filteredBeans() {
        return this.beans.filter(bean => {
            return bean.name.toLowerCase().includes(this.searchQuery.toLowerCase());
        });
    },

    get filteredMerch() {
        return this.merchandises.filter(merch => {
            const matchSearch = merch.name.toLowerCase().includes(this.searchQuery.toLowerCase());
            const matchOutlet = this.filterOutlet === '' || merch.outlets.some(o => o.id == this.filterOutlet);
            return matchSearch && matchOutlet;
        });
    },

    openAddBean() {
        this.editMode = false;
        this.formData = { id: '', name: '', origin: '', price: '', stock: '', image_path: '', outlet_id: '' };
        this.actionUrl = '{{ route('beans.store') }}';
        this.showModalBean = true;
    },
    openEditBean(bean) {
        this.editMode = true;
        this.formData = {
            id: bean.id,
            name: bean.name,
            origin: bean.origin,
            price: bean.price_250g,
            stock: bean.global_stock_kg,
            outlet_id: bean.outlets.length > 0 ? bean.outlets[0].id : '',
            image_path: bean.image_url ? '/storage/' + bean.image_url : ''
        };
        this.actionUrl = '/beans/update/' + bean.id;
        this.showModalBean = true;
    },
    openAddMerch() {
        this.editMode = false;
        this.formData = { id: '', name: '', category: '', price: '', stock: '', image_path: '', outlet_id: '' };
        this.actionUrl = '{{ route('merch.store') }}';
        this.showModalMerch = true;
    },
    openEditMerch(merch) {
        this.editMode = true;
        this.formData = {
            id: merch.id,
            name: merch.name,
            category: merch.category,
            price: merch.price,
            stock: merch.global_stock_unit,
            outlet_id: merch.outlets.length > 0 ? merch.outlets[0].id : '',
            image_path: merch.image_url ? '/storage/' + merch.image_url : ''
        };
        this.actionUrl = '/merch/update/' + merch.id;
        this.showModalMerch = true;
    },

    confirmDelete(event) {
        event.preventDefault();
        const form = event.target.closest('form');
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data yang dihapus tidak dapat dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
}"
    x-init="$nextTick(() => {
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: {{ Js::from(session('success')) }},
            showConfirmButton: false,
            timer: 3000
        });
        @endif
    
        @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Input Tidak Valid',
            html: '<ul class=\'text-left\'> @foreach ($errors->all() as $error) <
                li > -{{ $error }} < /li>
            @endforeach < /ul>',
        });
        @endif
    
        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Kesalahan Sistem',
            text: {{ Js::from(session('error')) }},
        });
        @endif
    });">

    <div class="flex h-screen overflow-hidden">
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 transition-transform duration-300 transform md:relative md:translate-x-0">
            @include('layouts.SidebarAdmin')
        </div>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/50 md:hidden"
            x-transition:enter="transition opacity-ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition opacity-ease-in duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        </div>

        <main class="flex-1 overflow-y-auto p-4 md:p-8">

            <div class="flex items-center md:hidden mb-6">
                <button @click="sidebarOpen = true" class="p-2 text-gray-600 dark:text-gray-300 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <span class="hidden font-bold text-gray-800 dark:text-white">Zocco Admin</span>
                <div class="hidden w-6"></div>
            </div>

            <header class="flex items-center justify-between mb-8">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100">Manajemen Produk</h1>
            </header>

            <div
                class="mb-6 flex flex-col lg:flex-row gap-4 lg:items-center justify-between bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="relative w-full lg:w-1/3">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input x-model="searchQuery" type="text" placeholder="Cari nama produk..."
                        class="w-full bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:border-yellow-500 outline-none">
                </div>

                <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                    <select x-show="activeTab !== 'beans'" x-model="filterOutlet" x-transition
                        class="bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 outline-none focus:border-yellow-500">
                        <option value="">Semua Outlet</option>
                        @foreach ($outlets as $outlet)
                            <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
                        @endforeach
                    </select>

                    <button @click="activeTab === 'beans' ? openAddBean() : openAddMerch()"
                        class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 font-semibold whitespace-nowrap shadow-md">
                        + Tambah <span x-text="activeTab === 'beans' ? 'Beans' : 'Merch'"></span>
                    </button>
                </div>
            </div>

            <div class="mb-8">
                <div class="border-b border-gray-200 dark:border-gray-700 overflow-x-auto">
                    <nav class="-mb-px flex space-x-8 min-w-max">
                        <button @click="activeTab = 'beans'; filterOutlet = ''"
                            :class="activeTab === 'beans' ? 'border-yellow-500 text-yellow-600 dark:text-yellow-300' :
                                'border-transparent text-gray-500'"
                            class="py-3 px-1 border-b-2 font-medium text-sm transition-all whitespace-nowrap">Biji
                            Kopi</button>
                        <button @click="activeTab = 'merchandise'"
                            :class="activeTab === 'merchandise' ? 'border-yellow-500 text-yellow-600 dark:text-yellow-300' :
                                'border-transparent text-gray-500'"
                            class="py-3 px-1 border-b-2 font-medium text-sm transition-all whitespace-nowrap">Merchandise</button>
                    </nav>
                </div>

                <div x-show="activeTab === 'beans'" class="mt-6" x-transition>
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-left">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr class="text-gray-500 dark:text-gray-400 text-xs uppercase font-bold">
                                    <th class="px-6 py-4">Gambar</th>
                                    <th class="px-6 py-4">Nama & Outlet</th>
                                    <th class="px-6 py-4">Harga</th>
                                    <th class="px-6 py-4">Stok</th>
                                    <th class="px-6 py-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                <template x-for="bean in filteredBeans" :key="bean.id">
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div
                                                class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-600">
                                                <img :src="bean.image_url ? '/storage/' + bean.image_url :
                                                    'https://via.placeholder.com/150'"
                                                    class="w-full h-full object-cover">
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-gray-900 dark:text-gray-100 font-bold" x-text="bean.name">
                                            </div>
                                            <div class="flex flex-wrap gap-1 mt-1">
                                                <template x-for="o in bean.outlets">
                                                    <span
                                                        class="text-[10px] bg-yellow-50 dark:bg-gray-900 text-yellow-700 dark:text-yellow-500 px-1.5 py-0.5 rounded border border-yellow-200 dark:border-gray-600 font-black uppercase"
                                                        x-text="o.name"></span>
                                                </template>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 text-sm font-bold">Rp
                                            <span
                                                x-text="new Intl.NumberFormat('id-ID').format(bean.price_250g)"></span>
                                        </td>
                                        <td class="px-6 py-4 text-green-600 dark:text-green-400 font-black text-sm">
                                            <span x-text="bean.global_stock_kg"></span> Kg
                                        </td>
                                        <td class="px-6 py-4 space-x-3 text-sm">
                                            <button @click="openEditBean(bean)"
                                                class="text-indigo-600 dark:text-indigo-400 hover:underline font-bold">Edit</button>
                                            <form :action="'/beans/destroy/' + bean.id" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" @click="confirmDelete($event)"
                                                    class="text-red-600 dark:text-red-400 hover:underline font-bold">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <div class="p-4">
                            {!! $beans->appends(['merch_page' => request('merch_page')])->links() !!}
                        </div>
                    </div>
                </div>

                <div x-show="activeTab === 'merchandise'" class="mt-6" x-transition>
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-left">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr class="text-gray-500 dark:text-gray-400 text-xs uppercase font-bold">
                                    <th class="px-6 py-4">Gambar</th>
                                    <th class="px-6 py-4">Nama & Outlet</th>
                                    <th class="px-6 py-4">Kategori</th>
                                    <th class="px-6 py-4">Harga</th>
                                    <th class="px-6 py-4">Stok</th>
                                    <th class="px-6 py-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                <template x-for="merch in filteredMerch" :key="merch.id">
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div
                                                class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-600">
                                                <img :src="merch.image_url ? '/storage/' + merch.image_url :
                                                    'https://via.placeholder.com/150'"
                                                    class="w-full h-full object-cover">
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-gray-900 dark:text-gray-100 font-bold"
                                                x-text="merch.name"></div>
                                            <div class="flex flex-wrap gap-1 mt-1">
                                                <template x-for="o in merch.outlets">
                                                    <span
                                                        class="text-[10px] bg-yellow-50 dark:bg-gray-900 text-yellow-700 dark:text-yellow-500 px-1.5 py-0.5 rounded border border-yellow-200 dark:border-gray-600 font-black uppercase"
                                                        x-text="o.name"></span>
                                                </template>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-gray-500 dark:text-gray-400 text-sm"
                                            x-text="merch.category"></td>
                                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 text-sm font-bold">Rp
                                            <span x-text="new Intl.NumberFormat('id-ID').format(merch.price)"></span>
                                        </td>
                                        <td class="px-6 py-4 text-green-600 dark:text-green-400 font-black text-sm">
                                            <span x-text="merch.global_stock_unit"></span> Unit
                                        </td>
                                        <td class="px-6 py-4 space-x-3 text-sm">
                                            <button @click="openEditMerch(merch)"
                                                class="text-indigo-600 dark:text-indigo-400 hover:underline font-bold">Edit</button>
                                            <form :action="'{{ url('merch/destroy') }}/' + merch.id" method="POST"
                                                class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" @click="confirmDelete($event)"
                                                    class="text-red-600 dark:text-red-400 hover:underline font-bold">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <div class="p-4">
                            {!! $merchandises->appends(['beans_page' => request('beans_page')])->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div x-show="showModalBean" class="fixed inset-0 z-[100] overflow-y-auto" x-cloak x-transition>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-black/75 backdrop-blur-sm" @click="showModalBean = false"></div>
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-lg p-6 md:p-8 z-[110] border dark:border-gray-700 relative">
                <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-6 uppercase tracking-tight"
                    x-text="editMode ? 'Edit Biji Kopi' : 'Tambah Biji Kopi'"></h3>
                <form :action="actionUrl" method="POST" enctype="multipart/form-data">
                    @csrf
                    <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>
                    <div class="space-y-4">
                        <div class="flex flex-col items-center p-4 bg-gray-50 dark:bg-gray-900 rounded-xl">
                            <img :src="formData.image_path || 'https://via.placeholder.com/150'"
                                class="w-32 h-32 object-cover rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 mb-4 shadow-inner">
                            <input type="file" name="image" :required="!editMode"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-black file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
                        </div>
                        <input type="text" name="name" x-model="formData.name" placeholder="Nama Beans"
                            class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl p-3 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-yellow-500"
                            required>
                        <input type="text" name="origin" x-model="formData.origin" placeholder="Asal (Origin)"
                            class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl p-3 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-yellow-500"
                            required>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-black uppercase text-gray-400 mb-1 block">Harga
                                    (250g)</label>
                                <input type="number" placeholder="Harga" name="price_250g" x-model="formData.price"
                                    class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl p-3 border border-gray-300 dark:border-gray-600"
                                    required>
                            </div>
                            <div>
                                <label class="text-xs font-black uppercase text-gray-400 mb-1 block">Stok (Kg)</label>
                                <input type="number" name="global_stock_kg" placeholder="Stok" x-model="formData.stock"
                                    class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl p-3 border border-gray-300 dark:border-gray-600"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 flex gap-3">
                        <button type="button" @click="showModalBean = false"
                            class="flex-1 py-3 text-gray-500 font-bold hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all">BATAL</button>
                        <button type="submit"
                            class="flex-1 py-3 bg-yellow-600 text-white rounded-xl font-black shadow-lg hover:bg-yellow-700 transition-all uppercase tracking-widest">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div x-show="showModalMerch" class="fixed inset-0 z-[100] overflow-y-auto" x-cloak x-transition>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-black/75 backdrop-blur-sm" @click="showModalMerch = false"></div>
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-lg p-6 md:p-8 z-[110] border dark:border-gray-700 relative">
                <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-6 uppercase tracking-tight"
                    x-text="editMode ? 'Edit Merchandise' : 'Tambah Merchandise'"></h3>
                <form :action="actionUrl" method="POST" enctype="multipart/form-data">
                    @csrf
                    <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>
                    <div class="space-y-4">
                        <div class="flex flex-col items-center p-4 bg-gray-50 dark:bg-gray-900 rounded-xl">
                            <img :src="formData.image_path || 'https://via.placeholder.com/150'"
                                class="w-32 h-32 object-cover rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 mb-4 shadow-inner">
                            <input type="file" name="image" :required="!editMode"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-black file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100">
                        </div>
                        <div>
                            <label
                                class="text-xs font-black uppercase text-gray-400 mb-1 block tracking-widest">Outlet</label>
                            <select name="outlet_id" x-model="formData.outlet_id" required
                                class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl p-3 border border-gray-300 dark:border-gray-600 outline-none focus:ring-2 focus:ring-yellow-500">
                                <option value="">Pilih Outlet</option>
                                @foreach ($outlets as $outlet)
                                    <option value="{{ $outlet->id }}">{{ $outlet->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="text" name="name" x-model="formData.name" placeholder="Nama Merchandise"
                            class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl p-3 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-yellow-500"
                            required>
                        <select name="category" x-model="formData.category"
                            class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl p-3 border border-gray-300 dark:border-gray-600 outline-none focus:ring-2 focus:ring-yellow-500"
                            required>
                            <option value="">Pilih Kategori</option>
                            <option value="Aksesoris">Aksesoris</option>
                            <option value="Pakaian">Pakaian</option>
                            <option value="Peralatan">Peralatan</option>
                        </select>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-black uppercase text-gray-400 mb-1 block">Harga (Rp)</label>
                                <input type="number" placeholder="Harga" name="price" x-model="formData.price"
                                    class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl p-3 border border-gray-300 dark:border-gray-600"
                                    required>
                            </div>
                            <div>
                                <label class="text-xs font-black uppercase text-gray-400 mb-1 block">Stok
                                    (Pcs)</label>
                                <input type="number" placeholder="Stok" name="global_stock_unit" x-model="formData.stock"
                                    class="w-full bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-xl p-3 border border-gray-300 dark:border-gray-600"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 flex gap-3">
                        <button type="button" @click="showModalMerch = false"
                            class="flex-1 py-3 text-gray-500 font-bold hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all">BATAL</button>
                        <button type="submit"
                            class="flex-1 py-3 bg-yellow-600 text-white rounded-xl font-black shadow-lg hover:bg-yellow-700 transition-all uppercase tracking-widest">SIMPAN</button>
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
