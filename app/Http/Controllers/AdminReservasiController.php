<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\Reservation;
use App\Models\ReservationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage; // Tambahkan ini
use App\Mail\ReservationNotification; 

class AdminReservasiController extends Controller
{
// File: app/Http/Controllers/AdminReservasiController.php

public function reservation()
{
    // Ambil data untuk tabel (dengan pagination)
    $reservations = Reservation::with(['outlet', 'user'])
        ->orderBy('reservation_date', 'desc')
        ->paginate(8);

    $outlets = Outlet::all();

    // HITUNG TOTAL UNTUK STATS CARD (Tanpa Pagination agar akurat)
    // Gunakan huruf kecil sesuai dengan isi database (pending, confirmed, cancelled)
    $totalCount = Reservation::count();
    $pendingCount = Reservation::where('status', 'pending')->count();
    $confirmedCount = Reservation::where('status', 'confirmed')->count();
    $cancelledCount = Reservation::where('status', 'cancelled')->count();

    return view('reservation', compact(
        'reservations', 
        'outlets', 
        'totalCount', 
        'pendingCount', 
        'confirmedCount', 
        'cancelledCount'
    ));
}

public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'outlet_id'        => 'required|exists:outlets,id',
            'customer_name'    => 'required|string|max:255',
            'phone_number'     => 'required',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'reservation_type' => 'required|in:reguler,vip',
            'guests'           => 'required|integer|min:1',
            'area'             => 'required_if:reservation_type,reguler|nullable|in:indoor,outdoor',
            'duration'         => 'required_if:reservation_type,vip|nullable|integer',
            'payment_proof'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
            'cart_data'        => 'nullable|string', // Data JSON dari keranjang belanja
            'dp'               => 'nullable|numeric',
        ]);

        try {
            // 2. Logika Upload Gambar Bukti DP (Jika ada)
            $path = null;
            if ($request->hasFile('payment_proof')) {
                // File disimpan di storage/app/public/payment_proofs
                $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            }

            // 3. Simpan Data Utama ke tabel 'reservations'
            // Menggunakan Auth::id() untuk menghindari error "undefined method id"
            $reservation = Reservation::create([
                'user_id'          => Auth::id(), 
                'outlet_id'        => $request->outlet_id,
                'customer_name'    => $request->customer_name,
                'phone_number'     => $request->phone_number,
                'reservation_date' => $request->reservation_date,
                'reservation_time' => $request->reservation_time,
                'reservation_type' => $request->reservation_type,
                'guests'           => $request->guests,
                'dp'               => $request->dp ?? 0,
                'area'             => $request->reservation_type === 'vip' ? 'vip' : $request->area, // Set VIP jika tipe VIP
                'duration'         => $request->reservation_type === 'vip' ? $request->duration : null,
                'payment_proof'    => $path, 
                'status'           => 'confirmed', // Admin input dianggap sudah konfirmasi
                'payment_status'   => ($request->dp > 0) ? 'paid' : 'unpaid',
                'note'             => $request->note,
            ]);

            // 4. Simpan Detail Menu ke tabel 'reservation_items'
            // Mengubah string JSON dari frontend menjadi array PHP
            $cart = json_decode($request->cart_data, true);
            
            if (is_array($cart) && count($cart) > 0) {
                foreach ($cart as $item) {
                    // Sesuai dengan tabel: reservation_id, menu_id, quantity, price_at_order, options, note
                    ReservationItem::create([
                        'reservation_id' => $reservation->id,
                        'menu_id'        => $item['id'],
                        'quantity'       => $item['qty'],         // Jumlah dibeli
                        'price_at_order' => $item['price'],       // Harga saat ini
                        'options'        => $item['name'] ?? null,  // Nama menu/pilihan kustom
                        'note'           => $item['opt'] ?? null,   // Catatan (misal: level pedas)
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Reservasi Berhasil! Data menu dan bukti DP telah tersimpan di database.');

        } catch (\Exception $e) {
            // Jika database gagal, hapus gambar yang baru saja diupload agar tidak memenuhi storage
            if ($path) {
                Storage::disk('public')->delete($path);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
    public function updatePaymentStatus(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update([
            'payment_status' => $request->payment_status
        ]);

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    public function updateStatus(Request $request, $id)
    {
        $reservation = Reservation::with('user', 'outlet')->findOrFail($id);
        $newStatus = strtolower($request->status);

        $reservation->update([
            'status' => $newStatus,
            'rejection_reason' => ($newStatus === 'cancelled') ? $request->rejection_reason : null
        ]);

        try {
            $recipientEmail = $reservation->user ? $reservation->user->email : null;
            if ($recipientEmail) {
                Mail::to($recipientEmail)->send(new ReservationNotification($reservation));
            }
            $message = 'Status reservasi diperbarui.';
        } catch (\Exception $e) {
            $message = 'Status diperbarui, email gagal dikirim.';
        }

        return redirect()->back()->with('success', $message);
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        
        // Hapus file gambar dari storage jika ada sebelum data dihapus
        if ($reservation->payment_proof) {
            Storage::disk('public')->delete($reservation->payment_proof);
        }

        $reservation->delete();
        return redirect()->back()->with('success', 'Reservasi berhasil dihapus.');
    }
}