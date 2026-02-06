<!DOCTYPE html>
<html lang="id">

@include('layouts.HeadAdmin')

{{-- Library External --}}
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    /* Custom styling agar kalender sesuai dengan desain Zocco */
    .fc .fc-button-primary {
        background-color: #0f172a;
        border-color: #0f172a;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.7rem;
        border-radius: 0.75rem;
    }

    .fc .fc-button-primary:hover {
        background-color: #000;
    }

    .fc .fc-button-primary:disabled {
        background-color: #4b5563;
    }

    .fc-event {
        cursor: pointer;
        border-radius: 6px;
        padding: 2px 5px;
        border: none;
        font-size: 0.75rem;
        transition: transform 0.2s;
    }

    .fc-event:hover {
        transform: scale(1.02);
    }

    .fc-toolbar-title {
        font-weight: 800 !important;
        font-style: italic;
        font-size: 1.25rem !important;
    }

    .dark .fc-theme-standard td,
    .dark .fc-theme-standard th {
        border-color: #374151;
    }

    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    /* Custom SweetAlert untuk Dark Mode */
    .dark .swal2-popup {
        background-color: #1f2937 !important;
        color: #fff !important;
    }
</style>

<body class="bg-gray-50 dark:bg-gray-900 font-sans antialiased" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-0">
            @include('layouts.SidebarAdmin')
        </div>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/50 lg:hidden"></div>

        <main id="main-content" class="flex-1 p-4 md:p-8 overflow-y-auto w-full">
            <header class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true"
                        class="p-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm lg:hidden focus:outline-none">
                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white italic">Manajemen
                            Reservasi</h1>
                        <p class="text-xs md:text-sm text-gray-500">Pantau dan kelola antrean meja pelanggan Anda.</p>
                    </div>
                </div>
            </header>

            {{-- Statistik --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6 mb-8">
                <div
                    class="bg-white dark:bg-gray-800 p-4 md:p-6 rounded-[2rem] shadow-sm border-l-4 border-blue-500 transition-all hover:shadow-md">
                    <div class="flex flex-col">
                        <p class="text-gray-500 text-[9px] md:text-xs uppercase font-black tracking-widest">Total
                            Reservasi</p>
                        <h3 class="text-xl md:text-3xl font-black dark:text-white mt-1 leading-none">
                            {{ $totalCount }}
                        </h3>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 p-4 md:p-6 rounded-[2rem] shadow-sm border-l-4 border-yellow-500 transition-all hover:shadow-md">
                    <div class="flex flex-col">
                        <p class="text-gray-500 text-[9px] md:text-xs uppercase font-black tracking-widest">Pending</p>
                        <h3 class="text-xl md:text-3xl font-black dark:text-white mt-1 leading-none">
                            {{ $pendingCount }}
                        </h3>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 p-4 md:p-6 rounded-[2rem] shadow-sm border-l-4 border-green-500 transition-all hover:shadow-md">
                    <div class="flex flex-col">
                        <p class="text-gray-500 text-[9px] md:text-xs uppercase font-black tracking-widest">Confirmed
                        </p>
                        <h3 class="text-xl md:text-3xl font-black dark:text-white mt-1 leading-none">
                            {{ $confirmedCount }}
                        </h3>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 p-4 md:p-6 rounded-[2rem] shadow-sm border-l-4 border-red-500 transition-all hover:shadow-md">
                    <div class="flex flex-col">
                        <p class="text-gray-500 text-[9px] md:text-xs uppercase font-black tracking-widest">Cancelled
                        </p>
                        <h3 class="text-xl md:text-3xl font-black dark:text-white mt-1 leading-none">
                            {{ $cancelledCount }}
                        </h3>
                    </div>
                </div>
            </div>

            {{-- Navigasi & Filter --}}
            <div class="mb-6 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div
                    class="flex w-full lg:w-auto bg-white dark:bg-gray-800 p-1 rounded-xl shadow-sm border dark:border-gray-700 overflow-x-auto no-scrollbar">
                    <button id="btn-list" onclick="toggleView('list')"
                        class="flex-1 lg:flex-none px-4 md:px-6 py-2 text-xs md:text-sm font-bold rounded-lg bg-slate-900 text-white shadow-md transition-all">Daftar</button>
                    <button id="btn-calendar" onclick="toggleView('calendar')"
                        class="flex-1 lg:flex-none px-4 md:px-6 py-2 text-xs md:text-sm font-bold rounded-lg text-gray-500 transition-all">Kalender</button>
                    <button id="btn-form" onclick="toggleView('form')"
                        class="flex-1 lg:flex-none px-4 md:px-6 py-2 text-xs md:text-sm font-bold rounded-lg text-gray-500 transition-all whitespace-nowrap">+
                        Tambah</button>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
                    <div class="relative w-full sm:w-64">
                        <input type="text" id="reservation-search" onkeyup="filterTable()" placeholder="Cari nama..."
                            class="pl-10 pr-4 py-2 w-full rounded-xl border dark:bg-gray-800 dark:border-gray-700 dark:text-white text-sm focus:ring-2 focus:ring-yellow-600 outline-none">
                        <svg class="w-4 h-4 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <select id="outlet-filter" onchange="globalFilter()"
                        class="w-full sm:w-auto p-2 py-2 rounded-xl border dark:bg-gray-800 dark:border-gray-700 dark:text-white text-sm outline-none">
                        <option value="all">Semua Outlet</option>
                        @foreach ($outlets as $outlet)
                            <option value="{{ $outlet->name }}">{{ $outlet->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Section List --}}
            <section id="view-list" class="space-y-4">
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl md:rounded-3xl shadow-sm border dark:border-gray-700 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700" id="resTable">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th
                                        class="px-4 md:px-6 py-4 text-left text-[9px] md:text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                        Customer</th>
                                    <th
                                        class="px-4 md:px-6 py-4 text-left text-[9px] md:text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                        Outlet</th>
                                    <th
                                        class="px-4 md:px-6 py-4 text-left text-[9px] md:text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                        Jadwal</th>
                                    <th
                                        class="px-4 md:px-6 py-4 text-left text-[9px] md:text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                        Pax</th>
                                    {{-- Kolom Baru --}}
                                    <th
                                        class="px-4 md:px-6 py-4 text-left text-[9px] md:text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                        Area / Durasi</th>
                                    <th
                                        class="px-4 md:px-6 py-4 text-left text-[9px] md:text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                        DP</th>
                                    <th
                                        class="px-4 md:px-6 py-4 text-left text-[9px] md:text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                        Status</th>
                                    <th
                                        class="px-4 md:px-6 py-4 text-right text-[9px] md:text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-xs md:text-sm">
                                @forelse($reservations as $res)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                        <td class="px-4 md:px-6 py-4">
                                            <div class="font-bold dark:text-white whitespace-nowrap">
                                                #RES-{{ $res->id }}</div>
                                            <div
                                                class="text-[10px] text-gray-500 uppercase truncate max-w-[100px] customer-name">
                                                {{ $res->customer_name }}</div>
                                            <div class="text-[9px] text-blue-500">{{ $res->phone_number }}</div>
                                            @if ($res->note)
                                                <button
                                                    onclick="swalNote('{{ addslashes($res->note) }}', '{{ $res->customer_name }}')"
                                                    class="mt-1 text-[8px] bg-yellow-100 text-yellow-700 px-1 py-0.5 rounded font-bold uppercase">Note</button>
                                            @endif
                                        </td>
                                        <td class="px-4 md:px-6 py-4">
                                            <span
                                                class="px-2 py-1 bg-blue-50 text-blue-600 rounded text-[9px] font-bold uppercase whitespace-nowrap outlet-name">{{ $res->outlet->name }}</span>
                                        </td>
                                        <td class="px-4 md:px-6 py-4">
                                            <div class="dark:text-gray-300 font-medium whitespace-nowrap">
                                                {{ \Carbon\Carbon::parse($res->reservation_date)->format('d/m/y') }}
                                            </div>
                                            <div class="text-[10px] text-yellow-600 font-bold">
                                                {{ \Carbon\Carbon::parse($res->reservation_time)->format('H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-4 md:px-6 py-4 dark:text-white font-bold">{{ $res->guests }}
                                        </td>

                                        {{-- Logic Area vs Duration --}}
                                        <td class="px-4 md:px-6 py-4">
                                            @if (strtolower($res->reservation_type) == 'vip')
                                                <div class="flex flex-col">
                                                    <span
                                                        class="text-[9px] text-gray-400 uppercase font-black">VIP</span>
                                                    <span
                                                        class="font-bold text-indigo-600 dark:text-indigo-400">{{ $res->duration }}
                                                        Jam</span>
                                                </div>
                                            @else
                                                <div class="flex flex-col">
                                                    <span
                                                        class="text-[9px] text-gray-400 uppercase font-black">Reguler</span>
                                                    <span
                                                        class="font-bold text-emerald-600 dark:text-emerald-400 italic uppercase">{{ $res->area ?? '-' }}</span>
                                                </div>
                                            @endif
                                        </td>

                                        <td class="px-4 md:px-6 py-4">
                                            @if ($res->payment_proof)
                                                <a href="{{ asset('storage/' . $res->payment_proof) }}"
                                                    target="_blank" class="block w-8 h-8">
                                                    <img src="{{ asset('storage/' . $res->payment_proof) }}"
                                                        class="h-8 w-8 object-cover rounded-md border" alt="DP">
                                                </a>
                                            @else
                                                <span class="text-[9px] text-gray-400 italic">No DP</span>
                                            @endif
                                        </td>
                                        <td class="px-4 md:px-6 py-4">
                                            @php
                                                $statusClasses = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'confirmed' => 'bg-green-100 text-green-800',
                                                    'cancelled' => 'bg-red-100 text-red-800',
                                                    'rejected' => 'bg-orange-100 text-orange-800',
                                                ];
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-black uppercase italic {{ $statusClasses[strtolower($res->status)] ?? 'bg-gray-100' }}">
                                                {{ $res->status }}
                                            </span>
                                        </td>
                                        <td class="px-4 md:px-6 py-4 text-right">
                                            <div class="flex justify-end items-center gap-2">
                                                <button onclick="showDetailMenu({{ $res->id }})"
                                                    class="p-1.5 bg-blue-600/10 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all"
                                                    title="Lihat Detail Menu">
                                                    <i class="fas fa-eye text-xs"></i>
                                                </button>
                                                @if ($res->status == 'confirmed')
                                                    <button onclick="generateInvoice({{ $res->id }})"
                                                        class="p-1.5 bg-green-600/10 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition-all"
                                                        title="Cetak Struk">
                                                        <i class="fas fa-file-invoice text-xs"></i>
                                                    </button>
                                                @endif
                                                @if ($res->status == 'pending')
                                                    <form action="{{ route('Reservation.updateStatus', $res->id) }}"
                                                        id="form-confirm-{{ $res->id }}" method="POST">
                                                        @csrf @method('PUT')
                                                        <input type="hidden" name="status" value="confirmed">
                                                        <button type="button"
                                                            onclick="swalConfirm('{{ $res->id }}')"
                                                            class="p-1.5 text-green-600 hover:bg-green-50 rounded-lg"
                                                            title="Konfirmasi">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    <button
                                                        onclick="swalReject('{{ $res->id }}', '{{ $res->customer_name }}')"
                                                        class="p-1.5 text-orange-600 hover:bg-orange-50 rounded-lg"
                                                        title="Tolak">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                @endif
                                                <form action="{{ route('Reservation.destroy', $res->id) }}"
                                                    id="form-delete-{{ $res->id }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="button"
                                                        onclick="swalDelete('{{ $res->id }}')"
                                                        class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg"
                                                        title="Hapus">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8"
                                            class="px-6 py-10 text-center text-gray-500 italic text-xs">
                                            Belum ada data reservasi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-4 px-2">
                    {{ $reservations->links() }}
                </div>
            </section>

            {{-- Section Calendar --}}
            <section id="view-calendar" class="hidden">
                <div
                    class="bg-white dark:bg-gray-800 p-3 md:p-6 rounded-2xl md:rounded-3xl shadow-sm border dark:border-gray-700">
                    <div id='calendar-container' class="min-h-[500px]"></div>
                </div>
            </section>

            {{-- Section Form --}}
            <section id="view-form" class="hidden max-w-5xl mx-auto">
                <div
                    class="bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-xl p-6 md:p-8 border dark:border-gray-700">
                    <div class="mb-8 border-b dark:border-gray-700 pb-4">
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white italic">
                            <i class="fas fa-plus-circle text-yellow-600 mr-2"></i>Reservasi Manual (Admin)
                        </h3>
                        <p class="text-xs text-gray-500 mt-1 uppercase tracking-widest font-bold">Input data pelanggan
                            untuk booking telepon / on-the-spot</p>
                    </div>

                    <form action="{{ route('Reservation.store') }}" method="POST" enctype="multipart/form-data"
                        id="adminReservationForm" class="space-y-6">
                        @csrf
                        <input type="hidden" name="cart_data" id="adminCartDataInput">

                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                            <div class="lg:col-span-7 space-y-5">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Nama
                                            Lengkap</label>
                                        <input type="text" name="customer_name" required
                                            placeholder="Contoh: John Doe" value="{{ old('customer_name') }}"
                                            class="w-full p-3 rounded-2xl border dark:bg-gray-900 dark:border-gray-700 dark:text-white outline-none focus:ring-2 focus:ring-yellow-600 transition-all">
                                    </div>
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">No.
                                            WhatsApp</label>
                                        <input type="tel" name="phone_number" required placeholder="62812..."
                                            value="{{ old('phone_number') }}"
                                            class="w-full p-3 rounded-2xl border dark:bg-gray-900 dark:border-gray-700 dark:text-white outline-none focus:ring-2 focus:ring-yellow-600 transition-all">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Pilih
                                            Outlet</label>
                                        <select name="outlet_id" id="admin-outlet-select" required
                                            onchange="loadAdminMenus()"
                                            class="w-full p-3 rounded-2xl border dark:bg-gray-900 dark:border-gray-700 dark:text-white outline-none focus:ring-2 focus:ring-yellow-600 transition-all">
                                            <option value="">Pilih Outlet</option>
                                            @foreach ($outlets as $outlet)
                                                <option value="{{ $outlet->id }}"
                                                    {{ old('outlet_id') == $outlet->id ? 'selected' : '' }}>
                                                    {{ $outlet->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Tipe
                                            Reservasi</label>
                                        <select name="reservation_type" id="admin_reservation_type"
                                            onchange="toggleAdminFields()" required
                                            class="w-full p-3 rounded-2xl border dark:bg-gray-900 dark:border-gray-700 dark:text-white outline-none focus:ring-2 focus:ring-yellow-600 transition-all">
                                            <option value="reguler">Reguler</option>
                                            <option value="vip">VIP</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-4 transition-all">
                                    <div id="admin_area_field" class="space-y-1.5">
                                        <label
                                            class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Pilih
                                            Area</label>
                                        <select name="area"
                                            class="w-full p-3 rounded-2xl border dark:bg-gray-900 dark:border-gray-700 dark:text-white outline-none focus:ring-2 focus:ring-yellow-600 transition-all">
                                            <option value="indoor">Indoor</option>
                                            <option value="outdoor">Outdoor</option>
                                        </select>
                                    </div>
                                    <div id="admin_duration_field" class="space-y-1.5 hidden">
                                        <label
                                            class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Durasi
                                            (Jam)</label>
                                        <input type="number" name="duration" min="1" placeholder="Contoh: 3"
                                            class="w-full p-3 rounded-2xl border dark:bg-gray-900 dark:border-gray-700 dark:text-white outline-none focus:ring-2 focus:ring-yellow-600 transition-all">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Tanggal</label>
                                        <input type="date" name="reservation_date" required
                                            value="{{ old('reservation_date') }}"
                                            class="w-full p-3 rounded-2xl border dark:bg-gray-900 dark:border-gray-700 dark:text-white outline-none focus:ring-2 focus:ring-yellow-600 transition-all">
                                    </div>
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Jam
                                            Kedatangan</label>
                                        <input type="time" name="reservation_time" required
                                            value="{{ old('reservation_time') }}"
                                            class="w-full p-3 rounded-2xl border dark:bg-gray-900 dark:border-gray-700 dark:text-white outline-none focus:ring-2 focus:ring-yellow-600 transition-all">
                                    </div>
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Jumlah
                                            Tamu</label>
                                        <input type="number" name="guests" min="1" required
                                            placeholder="Pax" value="{{ old('guests') }}"
                                            class="w-full p-3 rounded-2xl border dark:bg-gray-900 dark:border-gray-700 dark:text-white outline-none focus:ring-2 focus:ring-yellow-600 transition-all">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Status
                                            Reservasi</label>
                                        <select name="status"
                                            class="w-full p-3 rounded-2xl border dark:bg-gray-900 dark:border-gray-700 dark:text-white outline-none focus:ring-2 focus:ring-yellow-600 transition-all">
                                            <option value="confirmed">Konfirmasi</option>
                                            <option value="pending">Pending</option>
                                        </select>
                                    </div>
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Status
                                            Bayar</label>
                                        <select name="payment_status"
                                            class="w-full p-3 rounded-2xl border dark:bg-gray-900 dark:border-gray-700 dark:text-white outline-none focus:ring-2 focus:ring-yellow-600 transition-all">
                                            <option value="unpaid">Belum Bayar</option>
                                            <option value="paid">Sudah Bayar / DP</option>
                                        </select>
                                    </div>
                                    <div class="space-y-1.5">
                                        <label
                                            class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Nominal
                                            DP (Rp)</label>
                                        <input type="number" name="dp" placeholder="0"
                                            value="{{ old('dp', 0) }}"
                                            class="w-full p-3 rounded-2xl border border-yellow-500/30 dark:bg-gray-900 dark:text-white outline-none focus:ring-2 focus:ring-yellow-600 transition-all">
                                    </div>
                                </div>
                            </div>

                            <div class="lg:col-span-5 flex flex-col">
                                <div
                                    class="bg-gray-50 dark:bg-gray-900/50 p-6 rounded-[2.5rem] border border-dashed border-gray-200 dark:border-gray-700 h-full flex flex-col">
                                    <h4
                                        class="text-xs font-black uppercase tracking-widest text-yellow-600 mb-4 flex items-center gap-2">
                                        <i class="fas fa-utensils"></i> Pilih Menu Pesanan <span
                                            class="text-[9px] text-gray-400 font-normal">(Opsional / Onsite)</span>
                                    </h4>
                                    <div id="admin-menu-list"
                                        class="grid grid-cols-1 gap-2 max-h-[300px] overflow-y-auto mb-4 pr-2 custom-scrollbar">
                                        <p class="text-[10px] text-gray-400 italic text-center py-10">Pilih outlet
                                            terlebih dahulu untuk menampilkan menu.</p>
                                    </div>

                                    <div class="border-t dark:border-gray-700 pt-4 mt-auto">
                                        <h5
                                            class="text-[10px] font-black uppercase text-gray-400 mb-3 tracking-widest">
                                            Pesanan Terpilih:</h5>
                                        <div id="adminCartList" class="space-y-2 mb-4 max-h-[150px] overflow-y-auto">
                                        </div>

                                        <div
                                            class="flex justify-between items-center p-4 bg-white dark:bg-gray-800 rounded-2xl shadow-sm">
                                            <span class="text-xs font-bold dark:text-white">Total Estimasi:</span>
                                            <span id="adminCartTotal" class="text-base font-black text-yellow-600">Rp
                                                0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Bukti
                                    Pembayaran (Opsional)</label>
                                <input type="file" name="payment_proof" accept="image/*"
                                    class="w-full p-2.5 rounded-2xl border border-dashed border-gray-300 dark:border-gray-600 text-xs file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-yellow-50 file:text-yellow-700 transition-all">
                            </div>
                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-black uppercase tracking-widest text-gray-400 ml-1">Catatan
                                    Admin</label>
                                <textarea name="note" rows="2" placeholder="Catatan tambahan..."
                                    class="w-full p-3 rounded-2xl border dark:bg-gray-900 dark:border-gray-700 dark:text-white outline-none focus:ring-2 focus:ring-yellow-600 transition-all">{{ old('note') }}</textarea>
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row gap-3 pt-6">
                            <button type="submit"
                                class="flex-1 py-4 bg-slate-900 dark:bg-yellow-600 text-white font-black rounded-2xl shadow-lg hover:scale-[1.02] transition-all uppercase text-xs tracking-widest">
                                <i class="fas fa-save mr-2"></i> Simpan Reservasi & Pesanan
                            </button>
                            <button type="button" onclick="toggleView('list')"
                                class="px-10 py-4 bg-gray-100 dark:bg-gray-700 dark:text-white font-bold rounded-2xl hover:bg-gray-200 transition-all text-xs uppercase">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>

    <div id="modalDetail"
        class="fixed inset-0 z-[99] hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-[#0f172a] border border-white/10 w-full max-w-2xl rounded-[2rem] overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-white/5 flex justify-between items-center bg-white/[0.02]">
                <h3 class="text-xl font-playfair italic text-white">Detail Pesanan Menu</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-white text-2xl">&times;</button>
            </div>
            <div class="p-6">
                <div id="detailContent" class="space-y-4 max-h-[60vh] overflow-y-auto custom-scrollbar">
                </div>
            </div>
            <div class="p-6 border-t border-white/5 bg-white/[0.02] text-right">
                <button onclick="closeModal()"
                    class="px-6 py-2 bg-gray-700 text-white rounded-xl text-xs font-bold uppercase">Tutup</button>
            </div>
        </div>
    </div>
    {{-- Script Logic --}}
    <script>
        function toggleAdminFields() {
            const type = document.getElementById('admin_reservation_type').value;
            const areaField = document.getElementById('admin_area_field');
            const durationField = document.getElementById('admin_duration_field');

            if (type === 'reguler') {
                areaField.classList.remove('hidden');
                durationField.classList.add('hidden');
            } else {
                areaField.classList.add('hidden');
                durationField.classList.remove('hidden');
            }
        }
        //==========================================
        //catatan
        // Fungsi untuk menampilkan Catatan/Note Reservasi
        function swalNote(note) {
            Swal.fire({
                title: '<span class="text-lg font-black text-slate-800">Catatan Reservasi</span>',
                html: `
            <div class="text-left p-4 bg-slate-50 rounded-2xl border border-slate-200">
                <p class="text-slate-600 leading-relaxed italic">"${note || 'Tidak ada catatan khusus.'}"</p>
            </div>
        `,
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#0f172a',
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-xl px-10 py-2.5 text-sm font-bold'
                },
                showClass: {
                    popup: 'animate__animated animate__fadeInUp animate__faster'
                }
            });
        }


        // ==========================================
        // 1. Inisialisasi & Variabel Global
        // ==========================================
        let adminCart = [];
        let calendarInstance;
        let allEvents = [];

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });

        // ==========================================
        // 2. Logika Keranjang Admin (Tambah Reservasi Baru)
        // ==========================================

        async function loadAdminMenus() {
            const outletId = document.getElementById('admin-outlet-select').value;
            const menuContainer = document.getElementById('admin-menu-list');

            if (!outletId) {
                menuContainer.innerHTML =
                    '<p class="text-[10px] text-gray-400 italic text-center col-span-2">Pilih outlet terlebih dahulu...</p>';
                return;
            }

            menuContainer.innerHTML = '<div class="col-span-2 text-center py-4 text-xs">Memuat menu...</div>';

            try {
                const res = await fetch(`/api/menus?outlet_id=${outletId}`);
                const menus = await res.json();

                if (menus.length === 0) {
                    menuContainer.innerHTML =
                        '<div class="col-span-2 text-center py-4 text-xs text-red-500 font-bold">Tidak ada menu tersedia di outlet ini.</div>';
                    return;
                }

                menuContainer.innerHTML = menus.map(menu => `
                    <div class="p-2 bg-white border dark:bg-gray-700 dark:border-gray-600 rounded-lg flex justify-between items-center text-xs shadow-sm hover:border-amber-400 transition-all">
                        <div class="flex flex-col">
                            <span class="font-bold dark:text-white">${menu.name}</span>
                            <span class="text-[10px] text-amber-600 font-bold">Rp ${parseInt(menu.price).toLocaleString('id-ID')}</span>
                        </div>
                        <button type="button" onclick='addToAdminCart(${JSON.stringify(menu)})' 
                                class="bg-amber-500 hover:bg-amber-600 text-white w-6 h-6 flex items-center justify-center rounded-full transition-colors font-bold shadow-sm">+</button>
                    </div>
                `).join('');
            } catch (error) {
                menuContainer.innerHTML =
                    '<div class="col-span-2 text-center py-4 text-xs text-red-500">Gagal memuat data menu dari server.</div>';
            }
        }

        window.addToAdminCart = function(menu) {
            const exist = adminCart.findIndex(item => item.id === menu.id);
            if (exist > -1) {
                adminCart[exist].qty += 1;
            } else {
                adminCart.push({
                    id: menu.id,
                    name: menu.name,
                    price: menu.price,
                    qty: 1
                });
            }

            Toast.fire({
                icon: 'success',
                title: 'Menu ditambahkan'
            });
            renderAdminCart();
        };

        function renderAdminCart() {
            const list = document.getElementById('adminCartList');
            const totalEl = document.getElementById('adminCartTotal');
            const input = document.getElementById('adminCartDataInput');

            if (adminCart.length === 0) {
                list.innerHTML =
                    '<div class="text-center py-6"><i class="fas fa-shopping-basket text-gray-200 text-3xl mb-2"></i><p class="text-[10px] text-gray-400 italic">Keranjang kosong</p></div>';
                totalEl.innerText = 'Rp 0';
                input.value = '';
                return;
            }

            let total = 0;
            list.innerHTML = adminCart.map((item, index) => {
                const subtotal = item.price * item.qty;
                total += subtotal;
                return `
                    <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-700 p-2 rounded-lg mb-1 border border-gray-100 dark:border-gray-600">
                        <div class="flex-1">
                            <p class="text-[11px] font-bold dark:text-white">${item.name}</p>
                            <p class="text-[9px] text-gray-500 dark:text-gray-400">${item.qty} x Rp ${parseInt(item.price).toLocaleString('id-ID')}</p>
                        </div>
                        <button type="button" onclick="removeFromAdminCart(${index})" class="text-red-400 hover:text-red-600 p-1 transition-colors">
                            <i class="fas fa-trash-alt text-[10px]"></i>
                        </button>
                    </div>`;
            }).join('');

            totalEl.innerText = 'Rp ' + total.toLocaleString('id-ID');
            input.value = JSON.stringify(adminCart);
        }

        window.removeFromAdminCart = function(index) {
            adminCart.splice(index, 1);
            renderAdminCart();
        };

        // ==========================================
        // 3. Form & Status Actions
        // ==========================================

        document.getElementById('adminReservationForm')?.addEventListener('submit', function(e) {
            e.preventDefault();


            Swal.fire({
                title: 'Simpan Reservasi?',
                text: "Pastikan data pelanggan dan menu sudah benar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Simpan',
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#6b7280',
                customClass: {
                    popup: 'rounded-2xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        function swalConfirm(id) {
            Swal.fire({
                title: 'Konfirmasi Reservasi?',
                text: "Status akan diubah menjadi 'Confirmed'.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Konfirmasi!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-confirm-' + id).submit();
                }
            });
        }

        function swalReject(id, name) {
            Swal.fire({
                title: 'Tolak Reservasi',
                text: `Berikan alasan penolakan untuk ${name}:`,
                input: 'textarea',
                inputPlaceholder: 'Tulis alasan di sini...',
                showCancelButton: true,
                confirmButtonColor: '#ea580c',
                confirmButtonText: 'Kirim Penolakan',
                cancelButtonText: 'Batal',
                preConfirm: (reason) => {
                    if (!reason) {
                        Swal.showValidationMessage('Alasan wajib diisi!');
                    }
                    return reason;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/reservation/update-status/${id}`;

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = "{{ csrf_token() }}";

                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'PUT';

                    const status = document.createElement('input');
                    status.type = 'hidden';
                    status.name = 'status';
                    status.value = 'cancelled';

                    const reasonInput = document.createElement('input');
                    reasonInput.type = 'hidden';
                    reasonInput.name = 'rejection_reason';
                    reasonInput.value = result.value;

                    form.appendChild(csrf);
                    form.appendChild(method);
                    form.appendChild(status);
                    form.appendChild(reasonInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function swalDelete(id) {
            Swal.fire({
                title: 'Hapus Data?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-delete-' + id).submit();
                }
            });
        }

        // ==========================================
        // 4. Detail Modal & Invoice Struk
        // ==========================================

        function showDetailMenu(id) {
            fetch(`/admin/reservations/${id}/details`)
                .then(response => response.json())
                .then(data => {
                    let itemsHtml = '';
                    let grandTotal = 0;

                    // Kondisi jika ada data menu
                    if (data.menus && data.menus.length > 0) {
                        data.menus.forEach(item => {
                            const subtotal = item.qty * item.price;
                            grandTotal += subtotal;
                            itemsHtml += `
            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl border border-gray-100 mb-2">
                <div class="flex-1">
                    <p class="text-sm font-bold text-gray-800">${item.name}</p>
                    <p class="text-[10px] text-amber-600 font-bold uppercase">${item.options || 'Reguler'}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs font-black text-gray-900">${item.qty}x Rp ${parseInt(item.price).toLocaleString('id-ID')}</p>
                    <p class="text-[10px] text-gray-400">Total: Rp ${parseInt(subtotal).toLocaleString('id-ID')}</p>
                </div>
            </div>`;
                        });
                    } else {
                        itemsHtml = `
        <div class="p-6 text-center bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
            <i class="fas fa-store text-2xl text-gray-300 mb-2"></i>
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Pesanan Onsite</p>
            <p class="text-[10px] text-gray-400 italic">Pelanggan akan memesan menu langsung di lokasi.</p>
        </div>`;
                    }

                    const res = data.reservation;
                    let displayInfo = "";
                    let badgeClass = "";

                    if (res.reservation_type === 'vip') {
                        displayInfo = `<i class="fas fa-crown mr-1"></i> VIP (${res.duration || 0} Jam)`;
                        badgeClass = "bg-purple-100 text-purple-700";
                    } else {
                        const areaName = res.area ? res.area.toUpperCase() : 'REGULER';
                        const icon = areaName === 'OUTDOOR' ? 'fa-tree' : 'fa-couch';
                        displayInfo = `<i class="fas ${icon} mr-1"></i> ${areaName}`;
                        badgeClass = areaName === 'OUTDOOR' ? 'bg-green-100 text-green-700' :
                            'bg-blue-100 text-blue-700';
                    }

                    // PERUBAHAN DISINI: Kalkulasi sisa bayar
                    // Jika onsite (grandTotal 0), sisa bayar tetap 0 atau tampilkan sisa berdasarkan menu yang ada
                    const nominalDp = parseInt(res.dp || 0);
                    const kalkulasiSisa = grandTotal > 0 ? (grandTotal - nominalDp) : 0;
                    const sisaBayarDisplay = kalkulasiSisa < 0 ? 0 : kalkulasiSisa;

                    const content = `
    <div class="text-left space-y-4">
        <div class="flex justify-between items-center border-b border-gray-100 pb-3">
            <div>
                <p class="text-[9px] uppercase tracking-widest text-gray-400 font-bold">Tipe / Lokasi</p>
                <span class="px-3 py-1 rounded-full text-[10px] font-black ${badgeClass}">
                    ${displayInfo}
                </span>
            </div>
            <div class="text-right">
                <p class="text-[9px] uppercase tracking-widest text-gray-400 font-bold">Invoice ID</p>
                <p class="text-sm font-black text-gray-800">#RES-${id}</p>
            </div>
        </div>
        <div class="max-h-[250px] overflow-y-auto pr-1 no-scrollbar">
            <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-2">Item Pesanan</p>
            ${itemsHtml}
        </div>
        <div class="pt-3 border-t-2 border-dashed border-gray-100 space-y-1">
            <div class="flex justify-between items-center text-sm">
                <span class="text-gray-500">Total Harga Menu</span>
                <span class="text-gray-900 font-bold">Rp ${grandTotal.toLocaleString('id-ID')}</span>
            </div>
            
            <div class="flex justify-between items-center text-sm text-red-500">
                <span>Uang Muka (DP)</span>
                <span class="font-bold"> Rp ${nominalDp.toLocaleString('id-ID')}</span>
            </div>

            <div class="flex justify-between items-center mt-2 p-3 bg-amber-50 rounded-2xl border border-amber-100">
                <span class="text-xs font-bold text-amber-800 uppercase">Sisa Tagihan</span>
                <span class="text-lg font-black text-amber-900">Rp ${sisaBayarDisplay.toLocaleString('id-ID')}</span>
            </div>
        </div>
    </div>`;

                    Swal.fire({
                        title: '<span class="text-lg font-black tracking-tight">DETAIL RESERVASI</span>',
                        html: content,
                        confirmButtonText: 'Tutup',
                        confirmButtonColor: '#0f172a',
                        width: '450px',
                        customClass: {
                            popup: 'rounded-3xl'
                        }
                    });
                });
        }

        function generateInvoice(id) {
            Swal.fire({
                title: 'Menyiapkan Struk...',
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(`/admin/reservations/${id}/details`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const res = data.reservation;
                        const row = document.querySelector(`button[onclick="generateInvoice(${id})"]`).closest('tr');
                        const customerName = row.querySelector('.customer-name').innerText;
                        const outletName = row.querySelector('.outlet-name').innerText;
                        const dateRes = row.cells[2].innerText.replace('\n', ' ');

                        let itemsHtml = '';
                        let grandTotal = 0;

                        if (data.menus && data.menus.length > 0) {
                            data.menus.forEach(item => {
                                const subtotal = item.qty * item.price;
                                grandTotal += subtotal;
                                itemsHtml += `
                            <div class="mb-2">
                                <div class="flex justify-between text-[11px] font-bold">
                                    <span>${item.name}</span>
                                    <span>${(subtotal).toLocaleString('id-ID')}</span>
                                </div>
                                <div class="flex justify-between text-[10px] text-gray-600">
                                    <span>${item.qty} x ${parseInt(item.price).toLocaleString('id-ID')}</span>
                                    <span>${item.options || ''}</span>
                                </div>
                            </div>`;
                            });
                        } else {
                            itemsHtml =
                                `<div class="text-center py-2 text-[10px] italic text-gray-500">-- Pesanan Menu Onsite --</div>`;
                        }

                        const nominalDP = parseInt(res.dp || 0);
                        // Logika: Jika total 0 (onsite), sisa bayar tidak boleh minus DP
                        const sisaBayar = grandTotal > 0 ? Math.max(0, grandTotal - nominalDP) : 0;

                        const invoiceContent = `
                    <div id="receipt-content" class="text-left font-mono p-5 bg-white text-gray-900" style="font-family: 'Courier New', Courier, monospace; line-height: 1.2;">
                        <div class="text-center border-b-2 border-dashed border-gray-400 pb-3 mb-3">
                            <h2 class="font-black text-xl">STRUK</h2>
                            <p class="text-[10px] uppercase font-bold">${outletName}</p>
                            <p class="text-[9px]">Official Reservation Receipt</p>
                        </div>
                        <div class="text-[10px] mb-4 grid grid-cols-2 gap-y-1">
                            <span class="font-bold">No. Transaksi</span> <span>: #RES-${id}</span>
                            <span class="font-bold">Pelanggan</span> <span>: ${customerName}</span>
                            <span class="font-bold">Waktu Datang</span> <span>: ${dateRes}</span>
                            <span class="font-bold">Tipe / Pax</span> <span>: ${res.reservation_type} / ${res.guests} Pax</span>
                        </div>
                        <div class="border-b border-gray-300 mb-2 pb-1 text-[10px] font-bold text-center">--- RINCIAN BIAYA ---</div>
                        <div class="mb-4">${itemsHtml}</div>
                        <div class="border-t-2 border-dashed border-gray-400 pt-3 space-y-1 text-[11px]">
                            <div class="flex justify-between font-black text-sm">
                                <span>TOTAL MENU</span>
                                <span>Rp ${grandTotal.toLocaleString('id-ID')}</span>
                            </div>
                            <div class="flex justify-between font-bold text-blue-600">
                                <span>DP (SUDAH DIBAYAR)</span>
                                <span>Rp ${nominalDP.toLocaleString('id-ID')}</span>
                            </div>
                            <div class="flex justify-between font-black border-t border-gray-200 pt-1 text-base bg-gray-50 p-1">
                                <span>SISA DI KASIR</span>
                                <span>Rp ${sisaBayar.toLocaleString('id-ID')}</span>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-200 text-center">
                            <p class="text-[9px] italic">"Terima kasih. Sisa pembayaran dilakukan di kasir saat kedatangan."</p>
                            <p class="mt-4 text-[8px] uppercase tracking-widest text-gray-400 font-bold">*** RESERVASI CONFIRMED ***</p>
                        </div>
                    </div>`;

                        Swal.fire({
                            html: invoiceContent,
                            showCancelButton: true,
                            confirmButtonText: '<i class="fas fa-print mr-2"></i> Cetak Struk',
                            cancelButtonText: 'Tutup',
                            confirmButtonColor: '#000',
                            width: '380px',
                            customClass: {
                                popup: 'rounded-3xl',
                                confirmButton: 'rounded-xl text-xs py-3'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const printWindow = window.open('', '', 'height=600,width=450');
                                printWindow.document.write(
                                    '<html><head><title>Zocco Invoice</title><link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"></head><body>'
                                );
                                printWindow.document.write(document.getElementById('receipt-content')
                                    .innerHTML);
                                printWindow.document.write('</body></html>');
                                printWindow.document.close();
                                setTimeout(() => {
                                    printWindow.print();
                                    printWindow.close();
                                }, 800);
                            }
                        });
                    }
                })
                .catch(() => Swal.fire('Error', 'Gagal memproses data cetak struk.', 'error'));
        }

        // ==========================================
        // 5. Calendar & Layout Initialization
        // ==========================================

        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar-container');

            allEvents = [
                @foreach ($reservations as $res)
                    {
                        id: '{{ $res->id }}',
                        title: '{{ $res->customer_name }} ({{ $res->guests }}p)',
                        start: '{{ \Carbon\Carbon::parse($res->reservation_date)->format('Y-m-d') }}T{{ $res->reservation_time }}',
                        color: '{{ $res->status == 'confirmed' ? '#10b981' : ($res->status == 'pending' ? '#f59e0b' : '#ef4444') }}',
                        extendedProps: {
                            outlet: '{{ $res->outlet->name }}',
                            status: '{{ $res->status }}'
                        }
                    },
                @endforeach
            ];

            if (calendarEl) {
                calendarInstance = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'id',
                    // BAGIAN YANG DIPERBAIKI: Header toolbar agar ada week & list
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                    },
                    buttonText: {
                        today: 'Hari Ini',
                        month: 'Bulan',
                        week: 'Minggu',
                        day: 'Hari',
                        list: 'Agenda'
                    },
                    events: allEvents,
                    eventClick: (info) => showDetailMenu(info.event.id),
                    height: 'auto',
                    themeSystem: 'standard'
                });
                calendarInstance.render();
            }

            // Notifikasi Flash Laravel
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    html: `<div class="text-left text-xs">@foreach ($errors->all() as $error)<p>- {{ $error }}</p>@endforeach</div>`
                });
            @endif
        });

        // Toggle View Logic
        function toggleView(view) {
            const sections = ['view-list', 'view-calendar', 'view-form'];
            const buttons = {
                list: 'btn-list',
                calendar: 'btn-calendar',
                form: 'btn-form'
            };

            sections.forEach(s => document.getElementById(s).classList.add('hidden'));
            document.getElementById(`view-${view}`).classList.remove('hidden');

            Object.keys(buttons).forEach(key => {
                const btn = document.getElementById(buttons[key]);
                btn.classList.remove('bg-slate-900', 'text-white', 'shadow-md');
                btn.classList.add('text-gray-500');
            });

            const activeBtn = document.getElementById(buttons[view]);
            activeBtn.classList.add('bg-slate-900', 'text-white', 'shadow-md');
            activeBtn.classList.remove('text-gray-500');

            if (view === 'calendar' && calendarInstance) {
                setTimeout(() => {
                    calendarInstance.updateSize();
                    calendarInstance.render();
                }, 100);
            }
        }

        function filterTable() {
            globalFilter();
        }

        function globalFilter() {
            const outletFilter = document.getElementById('outlet-filter').value;
            const searchText = document.getElementById('reservation-search').value.toLowerCase();
            const rows = document.querySelectorAll('#resTable tbody tr');

            rows.forEach(row => {
                const customerData = row.querySelector('.customer-name')?.textContent.toLowerCase() || "";
                const outletData = row.querySelector('.outlet-name')?.textContent || "";

                const matchesSearch = customerData.includes(searchText);
                const matchesOutlet = (outletFilter === 'all' || outletData.includes(outletFilter));
                row.style.display = (matchesSearch && matchesOutlet) ? "" : "none";
            });

            if (calendarInstance) {
                const filteredEvents = allEvents.filter(event => {
                    const matchesOutlet = (outletFilter === 'all' || event.extendedProps.outlet === outletFilter);
                    const matchesSearch = event.title.toLowerCase().includes(searchText);
                    return matchesOutlet && matchesSearch;
                });
                calendarInstance.removeAllEvents();
                calendarInstance.addEventSource(filteredEvents);
            }
        }
    </script>
</body>

</html>
