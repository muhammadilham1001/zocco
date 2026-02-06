<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Menu;
use App\Models\Outlet;
use App\Models\Gallery;
use App\Models\Setting;
use App\Models\CoffeeBean;
use App\Models\HeroSetting;
use App\Models\Merchandise;
use App\Models\Reservation;
use App\Models\ReservationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationNotification;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $galleries = Gallery::all();
        $outlets = Outlet::orderBy('updated_at', 'desc')->get();
        $beans = CoffeeBean::take(4)->get();
        $merchandises = Merchandise::take(4)->get();
        
        $heroTitle = HeroSetting::where('key', 'hero_title')->first();
        $heroSubtitle = HeroSetting::where('key', 'hero_subtitle')->first();
        $heroBg = HeroSetting::where('key', 'hero_bg')->first();
        
        $slogan = Setting::where('key', 'slogan_utama')->first();
        $deskripsi = Setting::where('key', 'deskripsi_singkat')->first();

        return view('dashboard', compact('galleries', 'slogan', 'deskripsi', 'outlets', 'beans', 'merchandises', 'heroTitle', 'heroSubtitle', 'heroBg'));
    }

    /**
     * Menampilkan Halaman Riwayat & Form Reservasi User
     */
  public function reservasi(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    $outlets = Outlet::all();
    $menus = Menu::where('is_available', true)->get();

    // 1. Inisialisasi Query dengan Eager Loading
    $query = Reservation::where('user_id', Auth::id())
                ->with(['outlet', 'items.menu']);

    // 2. Terapkan Filter Status jika dipilih
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // 3. Urutkan berdasarkan yang TERBARU dibuat (created_at)
    // Kemudian bagi per 5 atau 10 data
    $reservations = $query->orderBy('created_at', 'desc')->paginate(10);

    // 4. Pertahankan parameter status di link pagination
    $reservations->appends($request->all());

    return view('user-reservation', compact('outlets', 'reservations', 'menus'));
}

    /**
     * Menyimpan data Reservasi dengan Kalkulasi DP Otomatis
     */
   public function storeReservasi(Request $request)
{
    // 1. Validasi Input Dasar dengan Pesan Bahasa Indonesia
    $request->validate([
        'outlet_id'        => 'required|exists:outlets,id',
        'reservation_type' => 'required|in:reguler,vip',
        'order_method'     => 'required|in:onsite,list',
        'reservation_date' => 'required|date|after_or_equal:today',
        'reservation_time' => 'required',
        'guests'           => 'required|integer|min:1',
        'phone_number'     => 'required|string',
        'payment_proof'    => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'duration'         => 'required_if:reservation_type,vip|nullable|integer',
        'note'             => 'nullable|string|max:500',
        'cart_data'        => 'nullable|string', 
        'area'             => 'required_if:reservation_type,reguler|nullable|in:indoor,outdoor',
    ], [
        // Custom Messages Bahasa Indonesia
        'outlet_id.required'        => 'Silakan pilih lokasi outlet terlebih dahulu.',
        'reservation_date.required' => 'Tanggal reservasi wajib diisi.',
        'reservation_date.after_or_equal' => 'Tanggal reservasi tidak boleh hari kemarin.',
        'reservation_time.required' => 'Jam kedatangan wajib dipilih.',
        'guests.required'           => 'Jumlah tamu wajib diisi.',
        'guests.min'                => 'Jumlah tamu minimal 1 orang.',
        'phone_number.required'     => 'Nomor telepon wajib diisi.',
        'payment_proof.required'    => 'Silakan unggah bukti transfer pembayaran DP.',
        'payment_proof.image'       => 'File bukti pembayaran harus berupa gambar.',
        'payment_proof.max'         => 'Ukuran gambar maksimal adalah 2MB.',
        'area.required_if'          => 'Silakan pilih area tempat duduk (Indoor/Outdoor).',
    ]);

    // 2. Logika Validasi Waktu (H-2 Jam & Waktu Lampau)
    $reservationDateTime = Carbon::parse($request->reservation_date . ' ' . $request->reservation_time);
    $now = Carbon::now();

    // Cek jika jam sudah lewat
    if ($reservationDateTime->isPast()) {
        return redirect()->back()->withInput()->with('error', 'Waktu yang Anda pilih sudah terlewat. Silakan pilih jam lain.');
    }

    // Cek minimal reservasi 2 jam sebelum kedatangan (khusus hari yang sama)
    if ($reservationDateTime->isToday()) {
        if ($reservationDateTime->diffInMinutes($now) < 120) {
            return redirect()->back()->withInput()->with('error', 'Untuk reservasi hari ini, mohon lakukan pemesanan minimal 2 jam sebelum waktu kedatangan.');
        }
    }

    // 3. Logika S&K Berdasarkan Tipe (Reguler/VIP)
    $resDate = Carbon::parse($request->reservation_date);
    $daysDifference = $now->startOfDay()->diffInDays($resDate->startOfDay(), false);
    
    if ($request->reservation_type === 'reguler') {
        if ($request->guests < 4) {
            return redirect()->back()->withInput()->with('error', 'Mohon maaf, reservasi reguler minimal untuk 4 orang.');
        }
        // Jika ingin mengaktifkan aturan H-1 Reguler:
        // if ($daysDifference < 1) {
        //     return redirect()->back()->withInput()->with('error', 'Reservasi reguler maksimal dilakukan H-1 (sehari sebelum).');
        // }
    }

    if ($request->reservation_type === 'vip' && $daysDifference < 2) {
        return redirect()->back()->withInput()->with('error', 'Reservasi VIP Room harus dilakukan minimal H-2 (dua hari sebelum).');
    }

    // 4. Kalkulasi DP Otomatis
    $guests = (int) $request->guests;
    $totalMinDP = 0;
    if ($guests >= 4 && $guests <= 15) $totalMinDP = $guests * 50000;
    else if ($guests >= 16 && $guests <= 30) $totalMinDP = $guests * 100000;
    else if ($guests >= 31) $totalMinDP = $guests * 200000;

    // 5. Handle Upload Bukti Transfer
    $paymentPath = null;
    if ($request->hasFile('payment_proof')) {
        $paymentPath = $request->file('payment_proof')->store('payments', 'public');
    }

    // 6. Simpan Data Reservasi
    $reservation = Reservation::create([
        'user_id'          => Auth::id(),
        'outlet_id'        => $request->outlet_id,
        'reservation_type' => $request->reservation_type,
        'order_method'     => $request->order_method,
        'customer_name'    => Auth::user()->name,
        'phone_number'     => $request->phone_number,
        'reservation_date' => $request->reservation_date,
        'reservation_time' => $request->reservation_time,
        'guests'           => $guests,
        'dp'               => $totalMinDP,
        'duration'         => $request->duration,
        'area'             => $request->reservation_type === 'vip' ? 'vip' : $request->area,
        'note'             => $request->note,
        'status'           => 'pending',
        'payment_proof'    => $paymentPath,
        'payment_status'   => 'pending',
    ]);

    // 7. Simpan Item Menu (Pre-order)
    if ($request->order_method === 'list' && $request->cart_data) {
        $cartData = json_decode($request->cart_data, true);
        if (is_array($cartData)) {
            foreach ($cartData as $item) {
                ReservationItem::create([
                    'reservation_id' => $reservation->id,
                    'menu_id'        => $item['id'],
                    'quantity'       => $item['qty'],
                    'price_at_order' => $item['price'],
                    'options'        => $item['opt'] ?? null,
                    'note'           => $item['note'] ?? null,
                ]);
            }
        }
    }

    // 8. Notifikasi Email
    try {
        $outlet = Outlet::find($request->outlet_id);
        Mail::to(Auth::user()->email)->send(new ReservationNotification($reservation, 'user'));
        if ($outlet && $outlet->email) {
            Mail::to($outlet->email)->send(new ReservationNotification($reservation, 'admin'));
        }
    } catch (\Exception $e) {
        // Abaikan jika email gagal kirim
    }

    return redirect()->back()->with('success', 'Reservasi Anda berhasil dibuat! Mohon tunggu konfirmasi dari admin kami.');
}

    /**
     * Memperbarui status reservasi (Fitur Cancel oleh User)
     */
    public function updateStatusReservasi(Request $request, $id)
    {
        $res = Reservation::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

        // Hanya boleh cancel jika status masih pending
        if ($res->status === 'pending' && $request->status === 'cancelled') {
            $res->update(['status' => 'cancelled']);
            return redirect()->back()->with('success', 'Reservasi Anda telah dibatalkan.');
        }

        return redirect()->back()->with('error', 'Reservasi tidak dapat dibatalkan pada status ini.');
    }

    /**
     * Menghapus reservasi (Jika diperlukan/Role User)
     */
    public function destroyReservasi($id)
    {
        $res = Reservation::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

        if ($res->payment_proof) {
            Storage::disk('public')->delete($res->payment_proof);
        }

        $res->delete();
        return redirect()->back()->with('success', 'Data reservasi berhasil dihapus dari riwayat.');
    }

    public function allProducts()
    {
        $beans = CoffeeBean::all();
        $merchandises = Merchandise::all()->unique('name');
        return view('detail-beansmer', compact('beans', 'merchandises'));
    }
}