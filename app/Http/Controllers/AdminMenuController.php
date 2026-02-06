<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Outlet;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminMenuController extends Controller
{
    public function manajemenmenu(Request $request)
    {
        $query = Menu::with(['outlet', 'category']);

        // 1. Logika Filter Outlet
        if ($request->filled('outlet_id') && $request->outlet_id !== 'all') {
            $query->where('outlet_id', $request->outlet_id);
        }

        // 2. Logika Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhereHas('outlet', function($sq) use ($search) {
                      $sq->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        $menus = $query->latest()->paginate(10);
        $outlets = Outlet::all();

        return view('ManajemenMenu', compact('menus', 'outlets'));
    }

    protected function customMessages()
    {
        return [
            'required' => ':attribute wajib diisi.',
            'numeric'  => ':attribute harus berupa angka.',
            'boolean'  => ':attribute harus dipilih.',
            'image'    => ':attribute harus berupa file gambar.',
            'max'      => ':attribute tidak boleh lebih dari :max KB.',
            'exists'   => ':attribute tidak valid.',
            'string'   => ':attribute harus berupa teks.',
            'in'       => ':attribute harus dipilih antara Makanan atau Minuman.',
        ];
    }

    protected function customAttributes()
    {
        return [
            'name'                     => 'Nama Menu',
            'price'                    => 'Harga',
            'is_available'             => 'Status Ketersediaan',
            'outlet_id'                => 'Outlet',
            'category_id'              => 'Kategori',
            'description'              => 'Deskripsi',
            'image'                    => 'Foto Menu',
            'type'                     => 'Tipe Menu',
            'allow_custom_note'        => 'Catatan Kustom',
            'allow_egg_option'         => 'Pilihan Telur',
            'allow_spicy_option'       => 'Pilihan Pedas',
            'allow_ice_sugar_level'    => 'Level Ice/Sugar',
        ];
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                  => 'required|string|max:255',
            'type'                  => 'required|in:makanan,minuman',
            'price'                 => 'required|numeric',
            'is_available'          => 'required|boolean',
            'outlet_id'             => 'required|exists:outlets,id',
            'category_id'           => 'required|exists:categories,id',
            'description'           => 'nullable|string',
            'image'                 => 'required|image|max:2048',
            'allow_custom_note'     => 'nullable',
            'allow_egg_option'      => 'nullable',
            'allow_spicy_option'    => 'nullable',
            'allow_ice_sugar_level' => 'nullable'
        ], $this->customMessages(), $this->customAttributes());

        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('uploads/menu', 'public');
        }

        // Handle Checkboxes (Ubah ke boolean)
        $data['allow_custom_note']     = $request->has('allow_custom_note');
        $data['allow_egg_option']      = $request->has('allow_egg_option');
        $data['allow_spicy_option']    = $request->has('allow_spicy_option');
        $data['allow_ice_sugar_level'] = $request->has('allow_ice_sugar_level');

        Menu::create($data);
        return back()->with('success', 'Produk berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        
        $data = $request->validate([
            'name'                  => 'required|string|max:255',
            'type'                  => 'required|in:makanan,minuman',
            'price'                 => 'required|numeric',
            'is_available'          => 'required|boolean',
            'outlet_id'             => 'required|exists:outlets,id',
            'category_id'           => 'required|exists:categories,id',
            'description'           => 'nullable|string',
            'image'                 => 'nullable|image|max:2048',
            'allow_custom_note'     => 'nullable',
            'allow_egg_option'      => 'nullable',
            'allow_spicy_option'    => 'nullable',
            'allow_ice_sugar_level' => 'nullable'
        ], $this->customMessages(), $this->customAttributes());

        if ($request->hasFile('image')) {
            if ($menu->image_url) { 
                Storage::disk('public')->delete($menu->image_url); 
            }
            $data['image_url'] = $request->file('image')->store('uploads/menu', 'public');
        }

        // Handle Checkboxes (Sangat Penting: Update harus eksplisit)
        $data['allow_custom_note']     = $request->has('allow_custom_note');
        $data['allow_egg_option']      = $request->has('allow_egg_option');
        $data['allow_spicy_option']    = $request->has('allow_spicy_option');
        $data['allow_ice_sugar_level'] = $request->has('allow_ice_sugar_level');

        $menu->update($data);
        return back()->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        if ($menu->image_url) { 
            Storage::disk('public')->delete($menu->image_url); 
        }
        $menu->delete();
        return back()->with('success', 'Produk berhasil dihapus!');
    }

    public function getCategories($outletId)
    {
        $categories = Category::where('outlet_id', $outletId)->get();
        return response()->json($categories);
    }

public function getDetails($id)
{
    // Ambil data reservasi beserta relasi outletnya
    $reservation = \App\Models\Reservation::with('outlet')->find($id);

    if (!$reservation) {
        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
    }

    // Ambil item menu dan harganya
    $items = DB::table('reservation_items')
        ->join('menus', 'reservation_items.menu_id', '=', 'menus.id')
        ->where('reservation_items.reservation_id', $id)
        ->select(
            'menus.name', 
            'reservation_items.quantity as qty', 
            'reservation_items.price_at_order as price', // Ambil harga
            'reservation_items.options',
            'reservation_items.note'
        )
        ->get();

    return response()->json([
        'success' => true,
        'reservation' => [
            'outlet_name' => $reservation->outlet->name,
            'reservation_date' => \Carbon\Carbon::parse($reservation->reservation_date)->format('d/m/Y'),
            'reservation_time' => $reservation->reservation_time,
            'type' => $reservation->reservation_type ?? 'Reguler', // Misal: VIP/Reguler
            'payment_method' => $reservation->payment_method ?? 'Transfer Bank',
            'guests' => $reservation->guests,
            'note' => $reservation->note,
            'dp' => $reservation->dp ?? 0
        ],
        'menus' => $items
    ]);
}
public function confirm($id)
{
    $reservation = \App\Models\Reservation::findOrFail($id);
    $reservation->update([
        'status' => 'confirmed',
        'payment_status' => 'paid' // Biasanya dikonfirmasi setelah bayar DP
    ]);

    return redirect()->back()->with('success', 'Reservasi berhasil dikonfirmasi!');
}
}