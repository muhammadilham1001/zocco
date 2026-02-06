<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HeroSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    public function index()
    {
        // Mengambil data berdasarkan key
        $heroTitle = HeroSetting::where('key', 'hero_title')->first();
        $heroSubtitle = HeroSetting::where('key', 'hero_subtitle')->first();
        $heroBg = HeroSetting::where('key', 'hero_bg')->first();

        return view('manage-dashboard-user', compact('heroTitle', 'heroSubtitle', 'heroBg'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        // Update Judul
        HeroSetting::updateOrCreate(['key' => 'hero_title'], ['value' => $request->hero_title]);

        // Update Subtitle
        HeroSetting::updateOrCreate(['key' => 'hero_subtitle'], ['value' => $request->hero_subtitle]);

        // Update Background Parallax
        if ($request->hasFile('hero_image')) {
            $setting = HeroSetting::where('key', 'hero_bg')->first();
            
            // Hapus foto lama jika ada
            if ($setting && $setting->image) {
                Storage::disk('public')->delete($setting->image);
            }

            $path = $request->file('hero_image')->store('hero', 'public');
            HeroSetting::updateOrCreate(['key' => 'hero_bg'], ['image' => $path]);
        }

        return back()->with('success', 'Tampilan Hero berhasil diperbarui!');
    }
}