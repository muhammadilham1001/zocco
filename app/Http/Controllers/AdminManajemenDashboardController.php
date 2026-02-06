<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminManajemenDashboardController extends Controller {
    
    public function managedashboard() {
        $galleries = Gallery::latest()->paginate(10);
        
        // Mengambil data teks berdasarkan key
        $slogan = Setting::where('key', 'slogan_utama')->first();
        $deskripsi = Setting::where('key', 'deskripsi_singkat')->first();

        // Pastikan nama view sesuai dengan file blade Anda
        return view('manage-dashboard-user', compact('galleries', 'slogan', 'deskripsi'));
    }

    /**
     * Pesan validasi kustom dalam Bahasa Indonesia
     */
    protected function customMessages() {
        return [
            'required' => ':attribute tidak boleh kosong.',
            'image'    => ':attribute harus berupa file gambar.',
            'mimes'    => ':attribute harus berformat: jpeg, png, atau jpg.',
            'max'      => ':attribute ukurannya tidak boleh lebih dari :max kilobita.',
            'string'   => ':attribute harus berupa teks.',
        ];
    }

    /**
     * Nama atribut agar lebih ramah dibaca
     */
    protected function customAttributes() {
        return [
            'judul'         => 'Judul Foto',
            'file_foto'     => 'File Foto',
            'slogan'        => 'Slogan Utama',
            'deskripsi'     => 'Deskripsi Singkat',
            'image_setting' => 'Gambar Promosi/About',
        ];
    }

    // SIMPAN FOTO BARU (Galeri)
    public function storeFoto(Request $request) {
        $request->validate([
            'judul' => 'required|string|max:255',
            'file_foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], $this->customMessages(), $this->customAttributes());

        if ($request->hasFile('file_foto')) {
            $path = $request->file('file_foto')->store('gallery', 'public');
            Gallery::create([
                'judul' => $request->judul,
                'image_path' => $path,
            ]);
        }

        return back()->with('success', 'Foto berhasil ditambahkan ke galeri!');
    }

    // HAPUS FOTO (Galeri)
    public function destroyFoto($id) {
        $foto = Gallery::findOrFail($id);
        
        // Hapus file fisik dari storage
        if ($foto->image_path) {
            Storage::disk('public')->delete($foto->image_path);
        }
        
        $foto->delete();

        return back()->with('success', 'Foto berhasil dihapus!');
    }

    // UPDATE TEKS & GAMBAR SETTING (Slogan, Deskripsi & Image Setting)
    public function updateText(Request $request) {
        $request->validate([
            'slogan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'image_setting' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], $this->customMessages(), $this->customAttributes());

        // Cari data setting yang sudah ada untuk slogan
        $settingSlogan = Setting::where('key', 'slogan_utama')->first();
        $imagePath = $settingSlogan ? $settingSlogan->image : null;

        // Jika ada file gambar baru yang diupload
        if ($request->hasFile('image_setting')) {
            // Hapus gambar lama dari storage jika ada
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            // Simpan gambar baru ke folder 'settings'
            $imagePath = $request->file('image_setting')->store('settings', 'public');
        }

        // 1. Update atau Buat data Slogan (beserta path gambarnya)
        Setting::updateOrCreate(
            ['key' => 'slogan_utama'], 
            [
                'value' => $request->slogan,
                'image' => $imagePath // Menggunakan nama kolom 'image'
            ]
        );

        // 2. Update atau Buat data Deskripsi
        Setting::updateOrCreate(
            ['key' => 'deskripsi_singkat'], 
            ['value' => $request->deskripsi]
        );

        return back()->with('success', 'Pengaturan teks dan gambar berhasil diperbarui!');
    }
}