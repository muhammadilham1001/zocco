<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminOutletController extends Controller
{
    public function manageoutlet()
    {
        $outlets = Outlet::latest()->paginate(5);
        return view('ManajemenOutlet', compact('outlets'));
    }

    protected function customMessages()
    {
        return [
            'required' => ':attribute wajib diisi.',
            'unique'   => ':attribute sudah digunakan, silakan gunakan nama lain.',
            'email'    => ':attribute harus berupa alamat email yang valid.',
            'image'    => ':attribute harus berupa file gambar.',
            'mimes'    => ':attribute harus berformat: jpeg, png, jpg, atau webp.',
            'max'      => ':attribute ukurannya terlalu besar.',
        ];
    }

    protected function customAttributes()
    {
        return [
            'name'  => 'Nama Outlet',
            'email' => 'Email Outlet',
            'city'  => 'Kota/Kabupaten',
            'image' => 'Foto Outlet',
            'logo'  => 'Logo Outlet',
            'wa'    => 'WhatsApp',
            'ig'    => 'Instagram',
            'tt'    => 'TikTok',
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|unique:outlets,name',
            'email' => 'required|email',
            'city'  => 'required',
            'wa'    => 'nullable|string|max:20',
            'ig'    => 'nullable|string|max:100',
            'tt'    => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10048',
            'logo'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:30048',
        ], $this->customMessages(), $this->customAttributes());

        $imagePath = $request->hasFile('image') ? $request->file('image')->store('outlets/images', 'public') : null;
        $logoPath = $request->hasFile('logo') ? $request->file('logo')->store('outlets/logos', 'public') : null;

        Outlet::create([
            'id'    => (string) Str::uuid(),
            'name'  => $request->name,
            'email' => $request->email,
            'city'  => $request->city,
            'wa'    => $request->wa,
            'ig'    => $request->ig,
            'tt'    => $request->tt,
            'image' => $imagePath,
            'logo'  => $logoPath,
        ]);

        return redirect()->back()->with('success', 'Outlet berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|unique:outlets,name,' . $id,
            'email' => 'required|email',
            'city'  => 'required',
            'wa'    => 'nullable|string|max:20',
            'ig'    => 'nullable|string|max:100',
            'tt'    => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10048',
            'logo'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:30048',
        ], $this->customMessages(), $this->customAttributes());

        $outlet = Outlet::findOrFail($id);
        
        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'city'  => $request->city,
            'wa'    => $request->wa,
            'ig'    => $request->ig,
            'tt'    => $request->tt,
        ];

        if ($request->hasFile('image')) {
            if ($outlet->image) Storage::disk('public')->delete($outlet->image);
            $data['image'] = $request->file('image')->store('outlets/images', 'public');
        }

        if ($request->hasFile('logo')) {
            if ($outlet->logo) Storage::disk('public')->delete($outlet->logo);
            $data['logo'] = $request->file('logo')->store('outlets/logos', 'public');
        }

        $outlet->update($data);

        return redirect()->back()->with('success', 'Outlet berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $outlet = Outlet::findOrFail($id);
        if ($outlet->image) Storage::disk('public')->delete($outlet->image);
        if ($outlet->logo) Storage::disk('public')->delete($outlet->logo);
        
        $outlet->delete();
        return redirect()->back()->with('success', 'Outlet berhasil dihapus!');
    }
}