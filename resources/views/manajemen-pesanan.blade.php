<!DOCTYPE html>
<html lang="id">

@include('layouts.HeadAdmin')

<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-500 ease-in-out font-poppins">
    <div class="flex h-screen">
        @include('layouts.SidebarAdmin')

        <main id="main-content" class="flex-1 p-8 overflow-y-auto">
            <header class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Manajemen Pesanan</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700 dark:text-gray-300">Halo, Admin!</span>
                    <button
                        class="flex items-center space-x-2 p-2 rounded-lg text-red-500 hover:bg-red-100 transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        <span>Logout</span>
                    </button>
                </div>
            </header>
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Daftar Pesanan</h2>
                <div class="flex space-x-2">
                    <button
                        class="px-4 py-2 text-sm font-semibold rounded-lg bg-yellow-500 text-white hover:bg-yellow-600 transition-colors duration-300">Semua</button>
                    <button
                        class="px-4 py-2 text-sm font-semibold rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 transition-colors duration-300">Diproses</button>
                    <button
                        class="px-4 py-2 text-sm font-semibold rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-300 transition-colors duration-300">Selesai</button>
                </div>
            </div>
            <section class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID Pesanan</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Pelanggan</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Waktu</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total</th>
                                <th
                                    class="px-6 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <tr>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                    #98765</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">Budi
                                    Santoso</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">10:15
                                    WIB</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">Rp
                                    120.000</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button class="text-indigo-600 hover:text-indigo-900">Lihat Detail</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    @include('layouts.JsAdmin')
</body>

</html>
