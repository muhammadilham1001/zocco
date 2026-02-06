<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CoffeeBean;
use App\Models\Merchandise;
use App\Models\Outlet;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminBeansmerController extends Controller
{
    public function managebeanmer()
    {
        $outlets = Outlet::all();
        $beans = CoffeeBean::with('outlets')->paginate(6, ['*'], 'beans_page'); 
        $merchandises = Merchandise::with('outlets')->paginate(6, ['*'], 'merch_page');

        return view('beans-merchan', compact('beans', 'merchandises', 'outlets'));
    }

    /**
     * Pesan validasi kustom dalam Bahasa Indonesia
     */
    protected function customMessages()
    {
        return [
            'required' => ':attribute wajib diisi.',
            'numeric'  => ':attribute harus berupa angka.',
            'integer'  => ':attribute harus berupa angka bulat.',
            'image'    => ':attribute harus berupa file gambar.',
            'max'      => ':attribute ukurannya tidak boleh lebih dari :max kilobita.',
            'exists'   => ':attribute yang dipilih tidak valid.',
        ];
    }

    /**
     * Nama atribut agar lebih ramah dibaca
     */
    protected function customAttributes()
    {
        return [
            'outlet_id'         => 'Outlet',
            'name'              => 'Nama Produk',
            'origin'            => 'Asal Biji (Origin)',
            'price_250g'        => 'Harga (250g)',
            'global_stock_kg'   => 'Stok (kg)',
            'global_stock_unit' => 'Jumlah Stok',
            'category'          => 'Kategori',
            'price'             => 'Harga Jual',
            'image'             => 'Foto Produk',
        ];
    }

    // --- LOGIKA BEANS (TANPA OUTLET ID & TANPA UNIQUE) ---
    public function storeBean(Request $request)
    {
        $request->validate([
            'name'            => 'required',
            'origin'          => 'required',
            'price_250g'      => 'required|numeric',
            'global_stock_kg' => 'required|integer',
            'image'           => 'nullable|image|max:10048'
        ], $this->customMessages(), $this->customAttributes());

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('uploads/beans', 'public');
            }

            CoffeeBean::create([
                'name'            => $request->name,
                'origin'          => $request->origin,
                'price_250g'      => $request->price_250g,
                'global_stock_kg' => $request->global_stock_kg,
                'image_url'       => $imagePath,
            ]);

            return back()->with('success', 'Biji Kopi berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function updateBean(Request $request, $id)
    {
        $bean = CoffeeBean::findOrFail($id);
        $request->validate([
            'name'            => 'required',
            'origin'          => 'required',
            'price_250g'      => 'required|numeric',
            'global_stock_kg' => 'required|integer',
            'image'           => 'nullable|image|max:10048'
        ], $this->customMessages(), $this->customAttributes());

        $data = $request->only(['name', 'origin', 'price_250g', 'global_stock_kg']);

        if ($request->hasFile('image')) {
            if ($bean->image_url) { Storage::disk('public')->delete($bean->image_url); }
            $data['image_url'] = $request->file('image')->store('uploads/beans', 'public');
        }

        $bean->update($data);
        return back()->with('success', 'Biji Kopi berhasil diperbarui!');
    }

    public function destroyBean($id)
    {
        $bean = CoffeeBean::findOrFail($id);
        if ($bean->image_url) { Storage::disk('public')->delete($bean->image_url); }
        $bean->delete();
        return back()->with('success', 'Biji Kopi berhasil dihapus!');
    }

    // --- LOGIKA MERCHANDISE (DENGAN OUTLET TAPI TANPA UNIQUE) ---
    public function storeMerch(Request $request)
    {
        $request->validate([
            'outlet_id'         => 'required|exists:outlets,id',
            'name'              => 'required',
            'category'          => 'required',
            'price'             => 'required|numeric',
            'global_stock_unit' => 'required|integer',
            'image'             => 'nullable|image|max:2048'
        ], $this->customMessages(), $this->customAttributes());

        try {
            DB::beginTransaction();

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('uploads/merch', 'public');
            }

            $merch = Merchandise::create([
                'name'              => $request->name,
                'category'          => $request->category,
                'price'             => $request->price,
                'global_stock_unit' => $request->global_stock_unit,
                'image_url'         => $imagePath,
            ]);

            $merch->outlets()->attach($request->outlet_id, [
                'stock_unit' => $request->global_stock_unit
            ]);

            DB::commit();
            return back()->with('success', 'Merchandise berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal sistem: ' . $e->getMessage());
        }
    }

    public function updateMerch(Request $request, $id)
    {
        $merch = Merchandise::findOrFail($id);
        
        $request->validate([
            'outlet_id'         => 'required|exists:outlets,id',
            'name'              => 'required',
            'category'          => 'required',
            'price'             => 'required|numeric',
            'global_stock_unit' => 'required|integer',
            'image'             => 'nullable|image|max:2048'
        ], $this->customMessages(), $this->customAttributes());

        try {
            DB::beginTransaction();

            $data = [
                'name'              => $request->name,
                'category'          => $request->category,
                'price'             => $request->price,
                'global_stock_unit' => $request->global_stock_unit,
            ];

            if ($request->hasFile('image')) {
                if ($merch->image_url) { Storage::disk('public')->delete($merch->image_url); }
                $data['image_url'] = $request->file('image')->store('uploads/merch', 'public');
            }

            $merch->update($data);

            $merch->outlets()->syncWithoutDetaching([
                $request->outlet_id => ['stock_unit' => $request->global_stock_unit]
            ]);

            DB::commit();
            return back()->with('success', 'Merchandise berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui data.');
        }
    }

    public function destroyMerch($id)
    {
        $merch = Merchandise::findOrFail($id);
        $merch->outlets()->detach();
        if ($merch->image_url) { Storage::disk('public')->delete($merch->image_url); }
        $merch->delete();
        return back()->with('success', 'Merchandise berhasil dihapus!');
    }
}