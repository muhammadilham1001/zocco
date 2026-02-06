<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;
use App\Models\Category;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('outlet')->paginate(10);
        $outlets = Outlet::all(); 
        return view('manajemen-kategori', compact('categories', 'outlets'));
    }

    /**
     * Pesan validasi kustom dalam Bahasa Indonesia
     */
    protected function customMessages()
    {
        return [
            'required' => ':attribute wajib diisi.',
            'exists'   => ':attribute yang dipilih tidak valid atau tidak ditemukan.',
            'string'   => ':attribute harus berupa teks.',
            'max'      => ':attribute tidak boleh lebih dari :max karakter.',
        ];
    }

    /**
     * Nama atribut agar lebih ramah dibaca
     */
    protected function customAttributes()
    {
        return [
            'outlet_id' => 'Pilihan Outlet',
            'name'      => 'Nama Kategori',
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'outlet_id' => 'required|exists:outlets,id',
            'name'      => 'required|string|max:255',
        ], $this->customMessages(), $this->customAttributes());

        Category::create($request->all());

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'outlet_id' => 'required|exists:outlets,id', 
        ], $this->customMessages(), $this->customAttributes());

        $category = Category::findOrFail($id);
        $category->update([
            'name'      => $request->name,
            'outlet_id' => $request->outlet_id,
        ]);

        return redirect()->back()->with('success', 'Kategori dan Outlet berhasil diperbarui!');
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            
            return redirect()->back()->with('success', 'Kategori berhasil dihapus selamanya.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus kategori. Pastikan tidak ada data menu yang masih menggunakan kategori ini.');
        }
    }
}