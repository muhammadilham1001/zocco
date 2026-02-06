<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DetailOutletController extends Controller
{
    // Tambahkan parameter $id
public function detailoulet($id)
{
    // 1. Ambil data outlet yang sedang dibuka
    $outlet = \App\Models\Outlet::findOrFail($id);
    
    // 2. Ambil SEMUA outlet untuk kebutuhan dropdown filter di header
    $outlets = \App\Models\Outlet::all(); 

    // 3. Ambil kategori unik yang ada di outlet ini
    $categories = \App\Models\Category::where('outlet_id', $id)->get();

    // 4. Ambil semua menu milik outlet ini
    $menus = \App\Models\Menu::where('outlet_id', $id)->with('category')->get();
    
    // Kirimkan $outlets juga ke view
    return view('DetailOuletZocco', compact('outlet', 'outlets', 'categories', 'menus'));
}
public function DetailMenu($id) {
    $outlet = \App\Models\Outlet::findOrFail($id);
    $categories = \App\Models\Category::where('outlet_id', $id)->get();
    
    // Ambil SEMUA menu tanpa batas untuk halaman detail
    $menus = \App\Models\Menu::where('outlet_id', $id)->with('category')->get();

    return view('DetailMenu', compact('outlet', 'categories', 'menus'));
}
}
