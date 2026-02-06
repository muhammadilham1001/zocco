<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zocco</title>
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --slate-dark: #020617;
            --slate-card: rgba(15, 23, 42, 0.8);
            --yellow-zocco: #ca8a04;
            --yellow-hover: #a16207;
            --text-gray: #94a3b8;
            --input-bg: #0f172a;
        }




        body {
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at top left, rgba(202, 138, 4, 0.05), var(--slate-dark)), var(--slate-dark);
            background-attachment: fixed;
            color: #f8fafc;
            min-height: 100vh;
        }

        .font-playfair {
            font-family: 'Playfair Display', serif;
        }

        .glass-card {
            background: var(--slate-card);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .input-dark {
            background: var(--input-bg);
            border: 1px solid #1e293b;
            color: white;
            transition: all 0.3s ease;
        }

        .input-dark:focus {
            border-color: var(--yellow-zocco);
            box-shadow: 0 0 0 2px rgba(202, 138, 4, 0.2);
            outline: none;
        }

        .btn-premium {
            background-color: var(--yellow-zocco);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: white;
        }

        .btn-premium:hover {
            background-color: var(--yellow-hover);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(202, 138, 4, 0.4);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(202, 138, 4, 0.3);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: var(--yellow-zocco);
        }

        .menu-card {
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.05);
            background: rgba(15, 23, 42, 0.4);
        }

        .menu-card:hover {
            border-color: rgba(202, 138, 4, 0.4);
            background: rgba(15, 23, 42, 0.6);
        }
    </style>
</head>

<body class="p-4 md:p-10 custom-scrollbar">

    <div class="max-w-[1400px] mx-auto">
        <header
            class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6 bg-white/5 p-6 rounded-[2.5rem] glass-card">
            <div class="text-center md:text-left">
                <h1 class="text-4xl md:text-5xl font-playfair font-bold italic tracking-tight">Zocco <span
                        class="text-[var(--yellow-zocco)]">Reservation</span></h1>
                <p class="text-[var(--text-gray)] text-[11px] tracking-[0.5em] uppercase mt-2">Exclusive Booking
                    Experience</p>
            </div>
            <a href="/dashboard"
                class="group flex items-center gap-3 px-8 py-3 rounded-2xl glass-card text-xs font-bold uppercase tracking-widest hover:bg-white/10 transition-all">
                <i
                    class="fas fa-arrow-left text-[var(--yellow-zocco)] group-hover:-translate-x-1 transition-transform"></i>
                Kembali ke Menu Utama
            </a>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <div class="lg:col-span-4 space-y-6">
                <div class="glass-card rounded-[2.5rem] p-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 opacity-10">
                        <i class="fas fa-calendar-alt text-6xl text-white"></i>
                    </div>

                    <h2 class="text-2xl font-playfair italic mb-8 flex items-center gap-3">
                        <span
                            class="w-8 h-8 bg-[var(--yellow-zocco)] rounded-full flex items-center justify-center text-white text-sm not-italic font-bold">1</span>
                        Detail Reservasi
                    </h2>

                    <form action="{{ route('user.reservation.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6" id="mainReservationForm" onsubmit="return validateForm(event)">
                        @csrf
                        <input type="hidden" name="cart_data" id="cartDataInput">

                        <div class="grid grid-cols-2 gap-3 p-1.5 bg-[#0f172a] rounded-2xl border border-white/5">
                            <label class="flex-1">
                                <input type="radio" name="reservation_type" value="reguler" class="hidden peer"
                                    checked onclick="toggleReservationType('reguler')">
                                <div
                                    class="py-3 text-center rounded-xl cursor-pointer transition-all peer-checked:bg-[var(--yellow-zocco)] peer-checked:text-white text-gray-500 text-xs font-bold uppercase">
                                    Reguler
                                </div>
                            </label>
                            <label class="flex-1">
                                <input type="radio" name="reservation_type" value="vip" class="hidden peer"
                                    onclick="toggleReservationType('vip')">
                                <div
                                    class="py-3 text-center rounded-xl cursor-pointer transition-all peer-checked:bg-[var(--yellow-zocco)] peer-checked:text-white text-gray-500 text-xs font-bold uppercase">
                                    VIP Room
                                </div>
                            </label>
                        </div>

                        <div class="mt-4 px-2 space-y-3">

                            <div id="reguler-note">
                                <div class="bg-white/5 border border-white/10 rounded-xl p-3">
                                    <p class="text-[10px] text-gray-400 italic flex items-center gap-2">
                                        <i class="fas fa-info-circle text-[var(--yellow-zocco)]"></i>
                                        <span>Minimal pembelanjaan: <span class="text-white font-bold">Rp 65.000 /
                                                orang</span></span>
                                    </p>
                                    <p class="text-[10px] text-gray-500 italic mt-1 ml-5">
                                        * Harga di bawah belum termasuk <span class="text-red-400 font-semibold">PPN
                                            10%</span>.
                                    </p>
                                </div>
                            </div>

                            <div id="vip-note" class="hidden">
                                <div class="bg-amber-500/10 border border-amber-500/20 rounded-2xl p-4">
                                    <div class="flex items-start gap-3">
                                        <div class="text-[var(--yellow-zocco)] mt-1">
                                            <i class="fas fa-crown text-sm"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h5 class="text-xs font-bold text-white mb-1 uppercase tracking-wider">
                                                Layanan VIP Room
                                            </h5>
                                            <p class="text-[10px] text-gray-300 leading-relaxed">
                                                Tersedia pilihan paket
                                                <span class="text-[var(--yellow-zocco)] font-bold">Buffet
                                                    (Prasmanan)</span>.
                                                Untuk detail menu dan kustomisasi, silakan hubungi admin outlet yang
                                                Anda pilih.
                                            </p>
                                            <p class="text-[9px] text-gray-500 italic mt-2">
                                                * Harga paket belum termasuk <span
                                                    class="text-red-400 font-semibold">PPN 10%</span>.
                                            </p>

                                            <button type="button" onclick="redirectToWhatsapp()"
                                                class="inline-flex items-center gap-2 mt-3 bg-[#25D366] hover:bg-[#1da851] text-white text-[10px] font-bold px-4 py-2 rounded-lg transition-all shadow-lg">
                                                <i class="fab fa-whatsapp text-sm"></i>
                                                HUBUNGI ADMIN BUFFET
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-bold text-[var(--yellow-zocco)] uppercase ml-2 tracking-widest">Metode
                                Pesanan Menu</label>
                            <div class="grid grid-cols-2 gap-3 p-1.5 bg-[#0f172a] rounded-2xl border border-white/5">
                                <label class="flex-1">
                                    <input type="radio" name="order_method" value="onsite" class="hidden peer" checked
                                        onclick="toggleOrderMethod('onsite')">
                                    <div
                                        class="py-3 text-center rounded-xl cursor-pointer transition-all peer-checked:bg-sky-600 peer-checked:text-white text-gray-500 text-[10px] font-bold uppercase">
                                        Onsite (Di Lokasi)</div>
                                </label>
                                <label class="flex-1">
                                    <input type="radio" name="order_method" value="list" class="hidden peer"
                                        onclick="toggleOrderMethod('list')">
                                    <div
                                        class="py-3 text-center rounded-xl cursor-pointer transition-all peer-checked:bg-sky-600 peer-checked:text-white text-gray-500 text-[10px] font-bold uppercase">
                                        List (Pre-Order)</div>
                                </label>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-bold text-[var(--yellow-zocco)] uppercase ml-2 tracking-widest">
                                    Pilih Outlet
                                </label>
                                <select name="outlet_id" id="outlet-select" onchange="handleOutletChange()" required
                                    class="input-dark w-full px-5 py-4 rounded-2xl text-sm appearance-none cursor-pointer">
                                    <option value="">-- Cari Lokasi Outlet --</option>
                                    @foreach ($outlets as $outlet)
                                        {{-- TAMBAHKAN data-wa="{{ $outlet->wa }}" DI SINI --}}
                                        <option value="{{ $outlet->id }}" data-name="{{ $outlet->name }}"
                                            data-wa="{{ $outlet->wa }}">
                                            {{ $outlet->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="areaInput" class="space-y-1.5 transition-all">
                                <label
                                    class="text-[10px] font-bold text-[var(--yellow-zocco)] uppercase ml-2 tracking-widest">Pilihan
                                    Area</label>
                                <select name="area"
                                    class="input-dark w-full px-5 py-4 rounded-2xl text-sm appearance-none cursor-pointer">
                                    <option value="indoor">Indoor (AC)</option>
                                    <option value="outdoor">Outdoor (Smoking)</option>
                                </select>
                            </div>

                            <div id="durationInput" class="space-y-1.5 hidden">
                                <label class="text-[10px] font-bold text-sky-400 uppercase ml-2 tracking-widest">Durasi
                                    Sewa (Jam)</label>
                                <input type="number" name="duration" placeholder="Min. 2 Jam"
                                    class="input-dark w-full px-5 py-4 rounded-2xl text-sm border-sky-500/30">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-bold text-[var(--yellow-zocco)] uppercase ml-2 tracking-widest">Tanggal</label>
                                <input type="date" name="reservation_date" min="{{ date('Y-m-d') }}" required
                                    class="input-dark w-full px-4 py-4 rounded-2xl text-xs">
                            </div>
                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-bold text-[var(--yellow-zocco)] uppercase ml-2 tracking-widest">Jam
                                    kedatangan</label>
                                <input type="time" name="reservation_time" required
                                    class="input-dark w-full px-4 py-4 rounded-2xl text-xs">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-bold text-[var(--yellow-zocco)] uppercase ml-2 tracking-widest">Jumlah
                                    Tamu</label>
                                <input type="number" name="guests" id="guestCount" oninput="calculateMinDP()"
                                    min="1" placeholder="Pax" required
                                    class="input-dark w-full px-5 py-4 rounded-2xl text-sm">
                            </div>

                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-bold text-[var(--yellow-zocco)] uppercase ml-2 tracking-widest">Nomor
                                    WA</label>
                                <input type="text" name="phone_number" placeholder="0812..." required
                                    class="input-dark w-full px-5 py-4 rounded-2xl text-sm">
                            </div>
                        </div>
                        <div class="space-y-1.5 mt-4">
                            <label
                                class="text-[10px] font-bold text-[var(--yellow-zocco)] uppercase ml-2 tracking-widest">
                                Catatan Tambahan (Opsional)
                            </label>
                            <textarea name="note" rows="3"
                                placeholder="Contoh: Meja dekat jendela, alergi kacang, atau ucapan ulang tahun..."
                                class="input-dark w-full px-5 py-4 rounded-2xl text-sm resize-none focus:ring-1 focus:ring-[var(--yellow-zocco)] outline-none transition-all"></textarea>
                        </div>

                        <div
                            class="bg-[#ca8a04]/10 border border-[#ca8a04]/20 p-5 rounded-[1.5rem] flex justify-between items-center">
                            <div>
                                <p class="text-[10px] text-[var(--yellow-zocco)] font-bold uppercase tracking-tighter">
                                    Minimum (DP)</p>
                                <p class="text-[9px] text-gray-400">*Berdasarkan jumlah pax</p>
                            </div>
                            <span id="minDPLabel" class="text-xl font-bold text-white">Rp 0</span>
                        </div>

                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-bold text-[var(--yellow-zocco)] uppercase ml-2 tracking-widest">Bukti
                                Transfer (BCA 0113107011)</label>
                            <div class="relative">
                                <input type="file" name="payment_proof" required
                                    class="input-dark w-full px-5 py-4 rounded-2xl text-[10px] file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-semibold file:bg-[var(--yellow-zocco)] file:text-white">
                            </div>
                        </div>

                        <button type="submit"
                            class="btn-premium w-full py-5 rounded-2xl font-bold tracking-[0.2em] text-sm uppercase shadow-2xl mt-4">
                            Selesaikan Reservasi <i class="fas fa-chevron-right ml-2 text-[10px]"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div id="menuCartSection" class="lg:col-span-8 space-y-6 hidden">
                <div class="glass-card rounded-[2.5rem] p-8 h-[720px] flex flex-col relative overflow-hidden">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
                        <h2 class="text-2xl font-playfair italic flex items-center gap-3">
                            <span
                                class="w-8 h-8 bg-[var(--yellow-zocco)] rounded-full flex items-center justify-center text-white text-sm not-italic font-bold">2</span>
                            Pilih Menu Spesial
                        </h2>

                        <div class="flex gap-3 w-full md:w-auto">
                            <div class="relative flex-1">
                                <i class="fas fa-search absolute left-4 top-3.5 text-gray-500 text-xs"></i>
                                <input type="text" id="menu-search" onkeyup="filterMenus()"
                                    placeholder="Cari kopi favorit..."
                                    class="bg-[#0f172a] border border-white/10 rounded-2xl pl-10 pr-4 py-3 text-xs w-full outline-none focus:border-[var(--yellow-zocco)] transition-all">
                            </div>
                            <select id="category-filter" onchange="filterMenus()"
                                class="bg-[#0f172a] border border-white/10 rounded-2xl px-4 py-3 text-xs outline-none cursor-pointer hover:border-[var(--yellow-zocco)] transition-all">
                                <option value="all">Semua</option>
                            </select>
                        </div>
                    </div>

                    <div id="menu-section"
                        class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5 overflow-y-auto custom-scrollbar pr-2 hidden">
                    </div>

                    <div id="outlet-not-selected"
                        class="flex-1 flex flex-col items-center justify-center text-center opacity-30">
                        <i class="fas fa-store text-6xl mb-4"></i>
                        <p class="italic text-sm">Silakan pilih outlet terlebih dahulu<br>untuk melihat daftar menu</p>
                    </div>
                </div>

                <div class="glass-card rounded-[2.5rem] p-8 border-l-4 border-l-[var(--yellow-zocco)]">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h2 class="text-xl font-playfair italic font-bold text-white">Rincian Pesanan</h2>
                            <p class="text-[10px] text-gray-500 uppercase tracking-widest">Review pesanan Anda sebelum
                                checkout</p>
                        </div>
                        <div class="text-right">
                            <span id="cartCount"
                                class="bg-[var(--yellow-zocco)] text-white text-[10px] px-4 py-1.5 rounded-full font-black uppercase tracking-tighter">0
                                Items</span>
                        </div>
                    </div>

                    <div id="cartList" class="space-y-3 mb-8 max-h-[300px] overflow-y-auto custom-scrollbar pr-2">
                        <div class="text-center py-12 border-2 border-dashed border-white/5 rounded-[2rem]">
                            <i class="fas fa-shopping-basket text-3xl mb-3 opacity-10"></i>
                            <p class="text-xs opacity-20 italic text-white">Belum ada menu yang dipilih</p>
                        </div>
                    </div>

                    <div
                        class="flex flex-col md:flex-row justify-between items-center gap-4 bg-[#0f172a]/80 p-6 rounded-[2rem]">
                        <div class="text-center md:text-left">
                            <span
                                class="text-[10px] uppercase font-bold text-[var(--yellow-zocco)] tracking-[0.3em]">Total
                                Pembayaran</span>
                            <div id="cartTotal" class="text-3xl font-bold text-white">Rp 0</div>
                        </div>
                        <div class="text-xs text-gray-400 italic text-center md:text-right max-w-xs leading-relaxed">
                            <span class="text-sky-400 font-bold">*Min. Order Menu senilai DP</span><br>
                            Sisa pembayaran dilakukan di outlet.
                        </div>
                    </div>
                </div>
            </div>

            <div id="onsitePlaceholder"
                class="lg:col-span-8 flex flex-col items-center justify-center p-12 glass-card rounded-[2.5rem] min-h-[400px]">
                <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-utensils text-4xl text-[var(--yellow-zocco)]"></i>
                </div>
                <h3 class="text-2xl font-playfair italic mb-2">Pemesanan Onsite</h3>
                <p class="text-gray-400 text-center max-w-md text-sm leading-relaxed">
                    Anda memilih untuk memesan menu langsung di tempat. Silakan selesaikan detail reservasi di samping
                    untuk mengamankan meja Anda.
                </p>
            </div>

        </div>

        <div class="mt-16 glass-card rounded-[2.5rem] overflow-hidden p-8">
            <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
                <h3 class="text-xl font-bold text-white tracking-tight">
                    Riwayat <span class="text-[var(--yellow-zocco)]">Reservasi</span>
                </h3>

                {{-- Filter Status --}}
                <form action="{{ route('user.reservation') }}" method="GET" class="flex items-center gap-2">
                    <label class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">Status:</label>
                    <select name="status" onchange="this.form.submit()"
                        class="bg-[#0f172a] text-white text-xs border border-white/10 rounded-xl px-4 py-2 focus:outline-none focus:border-[var(--yellow-zocco)] cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed
                        </option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                        </option>
                    </select>
                </form>
            </div>

            <div class="overflow-x-auto rounded-[2rem] border border-white/5 bg-[#0f172a]/30">
                <table class="w-full text-left border-collapse">
                    <thead
                        class="bg-[#0f172a] text-[var(--yellow-zocco)] uppercase text-[10px] font-black tracking-widest">
                        <tr>
                            <th class="px-8 py-5">Outlet & Tipe</th>
                            <th class="px-6 py-5">Jadwal Kedatangan</th>
                            <th class="px-6 py-5 text-center">Status</th>
                            <th class="px-8 py-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-sm">
                        @forelse($reservations as $res)
                            <tr class="hover:bg-white/[0.03] transition-colors group relative">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-[var(--yellow-zocco)]">
                                            <i class="fas fa-mug-hot"></i>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <p
                                                    class="font-bold text-white group-hover:text-[var(--yellow-zocco)] transition-colors">
                                                    {{ $res->outlet->name }}
                                                </p>
                                                @if ($loop->first && $reservations->currentPage() == 1)
                                                    <span
                                                        class="bg-[var(--yellow-zocco)] text-white text-[8px] px-2 py-0.5 rounded-full uppercase">Baru</span>
                                                @endif
                                            </div>
                                            <span class="text-[9px] text-gray-500 uppercase font-medium">
                                                {{ $res->reservation_type }} — {{ $res->area ?? 'VIP' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="font-medium text-white">
                                        {{ \Carbon\Carbon::parse($res->reservation_date)->format('d M Y') }}
                                    </p>
                                    <p class="text-[10px] text-gray-500 italic">{{ $res->reservation_time }} WIB</p>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @php
                                        $statusClass =
                                            [
                                                'pending' => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
                                                'confirmed' =>
                                                    'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                                'cancelled' => 'bg-red-500/10 text-red-400 border-red-500/20',
                                            ][$res->status] ?? 'bg-gray-500/10 text-gray-400 border-white/5';
                                    @endphp
                                    <span
                                        class="px-4 py-1.5 rounded-full {{ $statusClass }} text-[9px] font-black uppercase tracking-tighter border">
                                        {{ $res->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        @if ($res->status == 'pending')
                                            @if ($res->payment_proof)
                                                <button
                                                    onclick="showPaymentProof('{{ asset('storage/' . $res->payment_proof) }}')"
                                                    class="p-2 bg-blue-500/10 text-blue-400 rounded-lg hover:bg-blue-500 hover:text-white transition-all"
                                                    title="Lihat Bukti DP">
                                                    <i class="fas fa-receipt text-xs"></i>
                                                </button>
                                            @endif

                                            <form action="{{ route('user.reservation.destroy', $res->id) }}"
                                                method="POST" id="cancel-form-{{ $res->id }}">
                                                @csrf
                                                @method('delete')
                                                <button type="button" onclick="confirmCancel('{{ $res->id }}')"
                                                    class="p-2 bg-red-500/10 text-red-400 rounded-lg hover:bg-red-500 hover:text-white transition-all"
                                                    title="Batalkan Reservasi">
                                                    <i class="fas fa-times text-xs"></i>
                                                </button>
                                            </form>
                                        @endif

                                        @if ($res->status == 'confirmed')
                                            <button onclick="generateInvoice({{ $res->id }})"
                                                class="px-4 py-2 bg-[var(--yellow-zocco)] text-black rounded-xl text-[10px] font-black uppercase hover:scale-105 transition-transform flex items-center gap-2">
                                                <i class="fas fa-print"></i> Struk
                                            </button>
                                        @endif

                                        @if ($res->status == 'cancelled')
                                            <span
                                                class="text-gray-600 text-[10px] font-bold uppercase italic">Dibatalkan</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="bg-white/5 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-calendar-times text-2xl text-gray-600"></i>
                                        </div>
                                        <p class="text-gray-400 text-sm italic">Tidak ada data reservasi ditemukan
                                            untuk status ini.</p>
                                        @if (request('status'))
                                            <a href="{{ route('user.reservation') }}"
                                                class="text-[var(--yellow-zocco)] text-xs font-bold mt-4 inline-block hover:underline">
                                                Lihat Semua Reservasi
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-8 pagination-container">
                {{ $reservations->links() }}
            </div>
        </div>

        <style>
            /* Styling agar pagination Laravel tidak berantakan dan sesuai tema gelap */
            .pagination-container nav {
                display: flex;
                justify-content: center;
            }

            .pagination-container svg {
                width: 20px;
                height: 20px;
                display: inline;
            }

            .pagination-container .flex.justify-between.flex-1 {
                display: none;
                /* Sembunyikan versi mobile default laravel */
            }

            /* Styling angka-angka pagination */
            .pagination-container a,
            .pagination-container span {
                background-color: #0f172a !important;
                color: white !important;
                border: 1px solid rgba(255, 255, 255, 0.1) !important;
                padding: 8px 16px !important;
                border-radius: 12px !important;
                margin: 0 4px;
                font-size: 12px;
            }

            .pagination-container .active span {
                background-color: var(--yellow-zocco) !important;
                border-color: var(--yellow-zocco) !important;
            }
        </style>

        <footer class="mt-12 mb-8 text-center text-[10px] text-gray-600 uppercase tracking-[0.5em]">
            &copy; 2024 Zocco Coffee Roastery. All Rights Reserved.
        </footer>
    </div>

    <script>
        // 1. Inisialisasi Toast untuk notifikasi kecil
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // 2. Fungsi Konfirmasi Submit Form Reservasi (Tetap dipertahankan)
        function confirmSubmit(event) {
            // Fungsi ini dikosongkan karena logika dipindah ke event listener di bawah
            // untuk memastikan validasi berjalan sinkron.
        }

        // Tampilkan notifikasi jika ada session success dari Laravel
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#ca8a04',
                customClass: {
                    popup: 'rounded-[2rem] bg-[#111827] text-white'
                }
            });
        @endif

        function confirmCancel(id) {
            Swal.fire({
                title: 'Batalkan Reservasi?',
                text: "Tindakan ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#1f2937',
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Kembali',
                customClass: {
                    popup: 'rounded-[2rem] bg-[#111827] text-white'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`cancel-form-${id}`).submit();
                }
            });
        }

        // 2. Fungsi Lihat Bukti DP
        function showPaymentProof(url) {
            Swal.fire({
                title: 'Bukti Pembayaran DP',
                imageUrl: url,
                imageAlt: 'Bukti DP',
                showCloseButton: true,
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#1f2937',
                customClass: {
                    popup: 'rounded-[2rem] bg-[#111827] text-white'
                }
            });
        }

        function generateInvoice(id) {
            Swal.fire({
                title: 'Menyiapkan Struk...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(`/admin/reservations/${id}/details`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Gagal mengambil data. Status: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        let itemsHtml = '';
                        let grandTotal = 0;
                        const dpAmount = parseInt(data.reservation.dp || 0);

                        data.menus.forEach(item => {
                            const subtotal = item.qty * item.price;
                            grandTotal += subtotal;
                            itemsHtml += `
                    <div class="mb-2">
                        <div class="flex justify-between text-[11px] font-bold text-black">
                            <span>${item.name}</span>
                            <span>${parseInt(subtotal).toLocaleString('id-ID')}</span>
                        </div>
                        <div class="flex justify-between text-[10px] text-gray-600">
                            <span>${item.qty} x ${parseInt(item.price).toLocaleString('id-ID')}</span>
                            <span>${item.options ? `(${item.options})` : ''}</span>
                        </div>
                    </div>`;
                        });

                        const sisaBayar = grandTotal - dpAmount;

                        const invoiceContent = `
                <div id="receipt-content" class="text-left font-mono p-5 bg-white text-black shadow-inner" style="font-family: 'Courier New', Courier, monospace; width: 320px; margin: auto;">
                    <div class="text-center border-b-2 border-dashed border-gray-400 pb-3 mb-3">
                        <h2 class="font-black text-lg">STRUK</h2>
                        <p class="text-[10px] uppercase font-bold">${data.reservation.outlet_name || 'Outlet Zocco'}</p>
                    </div>
                    <div class="text-[10px] mb-4 space-y-1 text-black">
                        <div class="flex justify-between"><span>No. Transaksi</span> <span>#RES-${id}</span></div>
                    <div class="flex justify-between">
                    <span>Waktu</span> 
                    <span>${data.reservation.reservation_date} | ${data.reservation.reservation_time} WIB</span>
                    </div>
                        <div class="flex justify-between"><span>Tipe</span> <span>${data.reservation.type || 'Reguler'}</span></div>
                    </div>
                    <div class="border-b border-gray-300 mb-2 pb-1 text-[10px] font-bold text-center text-black">--- PESANAN ---</div>
                    <div class="mb-4 text-black">${itemsHtml}</div>
                    <div class="border-t-2 border-dashed border-gray-400 pt-3 text-black space-y-1">
                        <div class="flex justify-between text-[11px]">
                            <span>Subtotal Pesanan</span>
                            <span>Rp ${grandTotal.toLocaleString('id-ID')}</span>
                        </div>
                        <div class="flex justify-between text-[11px] text-red-600 italic">
                            <span>DP (Telah Dibayar)</span>
                            <span>- Rp ${dpAmount.toLocaleString('id-ID')}</span>
                        </div>
                        <div class="flex justify-between font-black text-sm border-t border-gray-200 pt-1 mt-1">
                            <span>SISA BAYAR</span>
                            <span>Rp ${sisaBayar > 0 ? sisaBayar.toLocaleString('id-ID') : 0}</span>
                        </div>
                    </div>
                    <div class="mt-6 text-center text-[9px] text-gray-500 italic">
                        *** RESERVASI TERKONFIRMASI ***
                        <br>Bawa struk ini saat datang ke outlet
                    </div>
                </div>`;

                        Swal.fire({
                            html: invoiceContent,
                            showCancelButton: true,
                            confirmButtonText: '<i class="fas fa-print mr-2"></i> Print',
                            cancelButtonText: 'Tutup',
                            confirmButtonColor: '#000',
                            width: 'auto',
                            customClass: {
                                popup: 'rounded-3xl'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const printWindow = window.open('', '', 'height=600,width=400');
                                printWindow.document.write('<html><head><title>Print Struk</title>');
                                printWindow.document.write(
                                    '<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">'
                                );
                                printWindow.document.write('</head><body class="bg-white p-4">');
                                printWindow.document.write(document.getElementById('receipt-content')
                                    .innerHTML);
                                printWindow.document.write('</body></html>');
                                printWindow.document.close();
                                setTimeout(() => {
                                    printWindow.print();
                                    printWindow.close();
                                }, 500);
                            }
                        });
                    } else {
                        Swal.fire('Error', 'Data menu tidak ditemukan', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Gagal memuat data. Periksa koneksi atau hubungi admin.', 'error');
                });
        }

        let cart = [];
        let allMenus = [];
        let currentDP = 0;

        // const activeMethod = document.querySelector('input[name="order_method"]:checked');
        // if (activeMethod) {
        //     toggleOrderMethod(activeMethod.value);
        // } else {
        //     toggleOrderMethod('onsite');
        // }

        // Tambahkan di bawah let currentDP = 0;
        window.redirectToWhatsapp = function() {
            const outletSelect = document.getElementById('outlet-select');
            const selectedOption = outletSelect.options[outletSelect.selectedIndex];

            // Ambil data WA dan Nama dari atribut data- di option
            const phone = selectedOption.getAttribute('data-wa');
            const outletName = selectedOption.getAttribute('data-name');

            if (!phone || phone === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Nomor Tidak Ditemukan',
                    text: 'Outlet ini belum mengatur nomor WhatsApp. Silakan hubungi outlet lain.',
                    background: '#0f172a',
                    color: '#fff',
                    confirmButtonColor: '#ca8a04'
                });
                return;
            }

            // Format pesan otomatis
            const message = encodeURIComponent(
                `Halo Admin Zocco ${outletName}, saya ingin menanyakan perihal reservasi VIP / Buffet.`);
            const waUrl = `https://wa.me/${phone.replace(/[^0-9]/g, '')}?text=${message}`;

            // Buka di tab baru
            window.open(waUrl, '_blank');
        };

        // VALIDASI LENGKAP
        window.validateForm = function(event) {
            const orderMethod = document.querySelector('input[name="order_method"]:checked').value;

            if (orderMethod === 'list') {
                // 1. Cek keranjang kosong
                if (cart.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Menu Belum Dipilih',
                        text: 'Silakan pilih menu terlebih dahulu atau pilih metode "Onsite".',
                        background: '#0f172a',
                        color: '#fff',
                        confirmButtonColor: '#ca8a04',
                        customClass: {
                            popup: 'rounded-[2rem]'
                        }
                    });
                    return false;
                }

                // 2. Cek Total Menu vs Nominal DP
                let totalMenu = cart.reduce((acc, item) => acc + (item.price * item.qty), 0);
                if (totalMenu < currentDP) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Total Menu Kurang',
                        text: `Minimal pembelian menu untuk Pre-Order adalah senilai DP (Rp ${currentDP.toLocaleString('id-ID')}). Total Anda saat ini baru Rp ${totalMenu.toLocaleString('id-ID')}.`,
                        background: '#0f172a',
                        color: '#fff',
                        confirmButtonColor: '#ca8a04',
                        customClass: {
                            popup: 'rounded-[2rem]'
                        }
                    });
                    return false;
                }
            }
            return true;
        };

        window.toggleReservationType = function(type) {
            const area = document.getElementById('areaInput');
            const duration = document.getElementById('durationInput');
            const outletSelect = document.getElementById('outlet-select');
            const options = outletSelect.querySelectorAll('option');
            const vipNote = document.getElementById('vip-note');
            const regulerNote = document.getElementById('reguler-note');

            if (type === 'vip') {
                area.classList.add('hidden');
                duration.classList.remove('hidden');
                if (vipNote) vipNote.classList.remove('hidden');
                if (regulerNote) regulerNote.classList.add('hidden');
            } else {
                area.classList.remove('hidden');
                duration.classList.add('hidden');
                if (vipNote) vipNote.classList.add('hidden');
                if (regulerNote) regulerNote.classList.remove('hidden');
            }

            options.forEach(opt => {
                if (opt.value === "") return;
                const name = opt.getAttribute('data-name').toLowerCase();
                if (type === 'vip') {
                    if (name.includes('elpico') || name.includes('heritage')) {
                        opt.style.display = 'block';
                    } else {
                        opt.style.display = 'none';
                    }
                } else {
                    opt.style.display = 'block';
                }
            });

            const selectedOpt = outletSelect.options[outletSelect.selectedIndex];
            if (selectedOpt && selectedOpt.style.display === 'none') {
                outletSelect.value = "";
                handleOutletChange();
            }
        };

        window.toggleOrderMethod = function(method) {
            const menuCartSection = document.getElementById('menuCartSection');
            const onsitePlaceholder = document.getElementById('onsitePlaceholder');
            const outletId = document.getElementById('outlet-select').value;

            if (method === 'list') {
                menuCartSection.classList.remove('hidden');
                onsitePlaceholder.classList.add('hidden');
                if (outletId) {
                    handleOutletChange();
                }
            } else {
                menuCartSection.classList.add('hidden');
                onsitePlaceholder.classList.remove('hidden');
                cart = [];
                renderCart();
            }
        };

        window.calculateMinDP = function() {
            const guests = parseInt(document.getElementById('guestCount').value) || 0;
            let totalMinDP = 0;
            if (guests >= 4 && guests <= 15) totalMinDP = guests * 50000;
            else if (guests >= 16 && guests <= 30) totalMinDP = guests * 100000;
            else if (guests >= 31) totalMinDP = guests * 200000;

            currentDP = totalMinDP;
            document.getElementById('minDPLabel').innerText = 'Rp ' + totalMinDP.toLocaleString('id-ID');
        };

        window.handleOutletChange = async function() {
            const outletId = document.getElementById('outlet-select').value;
            const menuSection = document.getElementById('menu-section');
            const placeholder = document.getElementById('outlet-not-selected');

            if (!outletId) {
                menuSection.classList.add('hidden');
                placeholder.classList.remove('hidden');
                return;
            }

            placeholder.classList.add('hidden');
            menuSection.classList.remove('hidden');
            menuSection.innerHTML =
                '<div class="col-span-full py-20 text-center"><i class="fas fa-spinner fa-spin text-2xl text-[var(--yellow-zocco)] mb-4"></i></div>';

            try {
                const resCat = await fetch(`/get-categories/${outletId}`);
                const categories = await resCat.json();
                const categoryFilter = document.getElementById('category-filter');
                categoryFilter.innerHTML = '<option value="all">Semua Kategori</option>';
                categories.forEach(cat => categoryFilter.innerHTML +=
                    `<option value="${cat.id}">${cat.name}</option>`);

                const resMenu = await fetch(`/api/menus?outlet_id=${outletId}`);
                allMenus = await resMenu.json();
                filterMenus();
            } catch (error) {
                menuSection.innerHTML =
                    '<p class="col-span-full text-center text-red-500 py-20">Gagal memuat menu.</p>';
            }
        };

        window.filterMenus = function() {
            const searchText = document.getElementById('menu-search').value.toLowerCase();
            const categoryId = document.getElementById('category-filter').value;
            const filtered = allMenus.filter(menu => {
                const matchesSearch = menu.name.toLowerCase().includes(searchText);
                const matchesCategory = (categoryId === 'all' || menu.category_id == categoryId);
                return matchesSearch && matchesCategory;
            });
            renderMenuCards(filtered);
        };

        window.renderMenuCards = function(menus) {
            const menuSection = document.getElementById('menu-section');
            menuSection.innerHTML = '';
            if (menus.length === 0) {
                menuSection.innerHTML =
                    '<p class="col-span-full text-center py-20 opacity-30 italic text-white">Menu tidak ditemukan...</p>';
                return;
            }
            menus.forEach(menu => {
                let optionsHtml = '';
                if (menu.type === 'makanan') {
                    if (menu.allow_egg_option == 1) optionsHtml +=
                        `<select id="egg-${menu.id}" class="w-full bg-[#020617] border border-white/10 rounded-xl px-3 py-2 text-[10px] text-white mb-2"><option value="Matang">Telur Matang</option><option value="Setengah Matang">Setengah Matang</option></select>`;
                    if (menu.allow_spicy_option == 1) optionsHtml +=
                        `<select id="spicy-${menu.id}" class="w-full bg-[#020617] border border-white/10 rounded-xl px-3 py-2 text-[10px] text-white mb-2"><option value="Tidak Pedas">Tidak Pedas</option><option value="Sedang">Sedang</option><option value="Pedas">Pedas</option></select>`;
                } else if (menu.type === 'minuman' && menu.allow_ice_sugar_level == 1) {
                    optionsHtml +=
                        `<div class="grid grid-cols-2 gap-2 mb-2"><select id="ice-${menu.id}" class="bg-[#020617] border border-white/10 rounded-xl px-2 py-2 text-[9px] text-white"><option value="Normal Ice">Normal Ice</option><option value="Less Ice">Less Ice</option></select><select id="sugar-${menu.id}" class="bg-[#020617] border border-white/10 rounded-xl px-2 py-2 text-[9px] text-white"><option value="Normal Sugar">Normal Sugar</option><option value="Less Sugar">Less Sugar</option></select></div>`;
                }
                if (menu.allow_custom_note == 1) optionsHtml +=
                    `<input type="text" id="note-${menu.id}" placeholder="Catatan..." class="w-full bg-[#020617] border border-white/10 rounded-xl px-3 py-2 text-[10px] text-white">`;

                menuSection.innerHTML += `
            <div class="menu-card glass-card p-5 flex flex-col rounded-[2rem]">
                <div class="relative mb-4 overflow-hidden rounded-2xl h-40">
                    <img src="/storage/${menu.image_url}" class="w-full h-full object-cover" onerror="this.src='https://via.placeholder.com/300x200?text=Zocco+Coffee'">
                </div>
                <h4 class="font-bold text-sm text-white mb-3">${menu.name}</h4>
                <div class="mb-4">${optionsHtml}</div>
                <div class="flex justify-between items-center mt-auto pt-4 border-t border-white/5">
                    <span class="text-[var(--yellow-zocco)] font-black text-sm">Rp ${Number(menu.price).toLocaleString('id-ID')}</span>
                    <button type="button" onclick="addToCart(${JSON.stringify(menu).replace(/"/g, '&quot;')})" class="bg-[var(--yellow-zocco)] text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase">Tambah</button>
                </div>
            </div>`;
            });
        };

        window.addToCart = function(menu) {
            let opts = [];
            if (menu.type === 'makanan') {
                const e = document.getElementById(`egg-${menu.id}`);
                const s = document.getElementById(`spicy-${menu.id}`);
                if (e) opts.push(e.value);
                if (s) opts.push(s.value);
            } else {
                const i = document.getElementById(`ice-${menu.id}`);
                const sg = document.getElementById(`sugar-${menu.id}`);
                if (i) opts.push(i.value);
                if (sg) opts.push(sg.value);
            }
            const noteInput = document.getElementById(`note-${menu.id}`);
            const noteVal = noteInput ? noteInput.value : '';
            const optString = opts.join(', ');

            const exist = cart.findIndex(item => item.id === menu.id && item.opt === optString && item.note ===
                noteVal);
            if (exist > -1) cart[exist].qty += 1;
            else cart.push({
                id: menu.id,
                name: menu.name,
                price: menu.price,
                opt: optString,
                note: noteVal,
                qty: 1
            });

            Toast.fire({
                icon: 'success',
                title: menu.name + ' berhasil ditambah'
            });
            renderCart();
        };

        window.changeQty = function(i, d) {
            cart[i].qty += d;
            if (cart[i].qty < 1) cart.splice(i, 1);
            renderCart();
        };

        window.removeFromCart = function(i) {
            cart.splice(i, 1);
            renderCart();
        };

        window.renderCart = function() {
            const list = document.getElementById('cartList');
            const totalEl = document.getElementById('cartTotal');
            const cartInput = document.getElementById('cartDataInput');
            const cartCount = document.getElementById('cartCount');

            if (cart.length === 0) {
                list.innerHTML =
                    `<div class="text-center py-12 opacity-20 italic text-white text-xs">Belum ada menu dipilih</div>`;
                totalEl.innerText = 'Rp 0';
                cartCount.innerText = '0 Items';
                cartInput.value = "";
                return;
            }

            let html = '',
                total = 0,
                count = 0;
            cart.forEach((item, index) => {
                total += (item.price * item.qty);
                count += item.qty;
                html += `<div class="flex justify-between items-center p-4 bg-white/[0.03] rounded-2xl border border-white/5 mb-2">
                <div class="flex-1">
                    <p class="text-[13px] font-bold text-white">${item.name}</p>
                    <p class="text-[9px] text-[var(--yellow-zocco)]">${item.opt || 'Normal'}</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center bg-black/40 rounded-lg">
                        <button onclick="changeQty(${index},-1)" class="w-8 h-8 text-amber-500">-</button>
                        <span class="w-8 text-center text-xs text-white">${item.qty}</span>
                        <button onclick="changeQty(${index},1)" class="w-8 h-8 text-amber-500">+</button>
                    </div>
                    <button onclick="removeFromCart(${index})" class="text-red-400/50 hover:text-red-400"><i class="fas fa-trash-alt text-xs"></i></button>
                </div>
            </div>`;
            });
            list.innerHTML = html;
            totalEl.innerText = 'Rp ' + total.toLocaleString('id-ID');
            cartCount.innerText = count + ' Items';
            cartInput.value = JSON.stringify(cart);
        };

        document.addEventListener('DOMContentLoaded', () => {
            calculateMinDP();
            renderCart();
            // toggleOrderMethod('onsite');

            // 1. Alert untuk pesan "error" dari Controller (Validasi S&K Waktu/Tamu)
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#ca8a04',
                    customClass: {
                        popup: 'rounded-[2rem] bg-[#111827] text-white',
                    }
                });
            @endif

            // 2. Alert untuk Validasi Laravel Default ($request->validate)
            @if ($errors->any())
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    confirmButtonColor: '#ca8a04',
                    customClass: {
                        popup: 'rounded-[2rem] bg-[#111827] text-white',
                    }
                });
            @endif

            // PERBAIKAN: Gunakan ID 'mainReservationForm' agar sesuai dengan HTML Anda
            const form = document.getElementById('mainReservationForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Jalankan Validasi Terlebih Dahulu
                    if (!validateForm(e)) {
                        return; // Jika validasi gagal, berhenti di sini (alert sudah muncul di validateForm)
                    }

                    // Jika validasi lolos, baru tampilkan konfirmasi kirim
                    Swal.fire({
                        title: 'Konfirmasi Reservasi',
                        text: "Apakah Anda yakin data reservasi dan pesanan sudah benar?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#ca8a04',
                        cancelButtonColor: '#1f2937',
                        confirmButtonText: 'Ya, Kirim Sekarang!',
                        cancelButtonText: 'Cek Kembali',
                        customClass: {
                            popup: 'rounded-[2rem] bg-[#111827] text-white',
                            title: 'text-white',
                            htmlContainer: 'text-gray-300'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Sedang Memproses...',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                            form.submit();
                        }
                    });
                });
            }
        });
    </script>
</body>
</html>