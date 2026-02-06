<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class AuthController extends Controller {
    
    public function showLogin() { 
        return view('Login'); 
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            if (Auth::user()->role === 'admin') {
                return redirect()->route('DashboardAdmin');
            }
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function showRegister() { 
        return view('Register'); 
    }

    /**
     * Langkah 1: Validasi & Kirim OTP
     */
    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        // Generate 6 Digit Kode Random
        $otp = rand(100000, 999999);

        // Simpan data pendaftaran sementara di Session
        Session::put('register_data', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash sekarang agar siap simpan
            'otp' => $otp,
        ]);

        // Kirim Email (Menggunakan Mail Inline agar simpel)
        try {
            Mail::raw("Kode verifikasi Anda adalah: $otp. Jangan berikan kode ini kepada siapapun.", function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Verifikasi Akun Zocco Coffee');
            });
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim email verifikasi. Cek koneksi internet/SMTP.']);
        }

        return redirect()->route('register.verify.show')->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }

    /**
     * Langkah 2: Tampilkan Halaman Input OTP
     */
    public function showVerifyOtp() {
        if (!Session::has('register_data')) {
            return redirect()->route('register');
        }
        return view('Verify'); // Pastikan Anda membuat view ini
    }

    /**
     * Langkah 3: Validasi OTP & Simpan User ke DB
     */
    public function verifyOtp(Request $request) {
        $request->validate([
            'otp' => 'required|numeric'
        ]);

        $sessionData = Session::get('register_data');

        if (!$sessionData) {
            return redirect()->route('register')->withErrors(['email' => 'Sesi berakhir, silakan daftar ulang.']);
        }

        // Cek apakah OTP cocok
        if ($request->otp == $sessionData['otp']) {
            // Jika Cocok, Buat User Permanen
            User::create([
                'name' => $sessionData['name'],
                'email' => $sessionData['email'],
                'password' => $sessionData['password'],
                'role' => 'user', 
            ]);

            // Hapus Session
            Session::forget('register_data');

            return redirect()->route('login')->with('success', 'Akun berhasil diverifikasi! Silakan login.');
        }

        return back()->withErrors(['otp' => 'Kode OTP salah atau tidak sesuai.']);
    }

    public function showForgotPassword() {
    return view('Forgot-Password');
}

public function sendResetOtp(Request $request) {
    $request->validate(['email' => 'required|email|exists:users,email']);

    $otp = rand(100000, 999999);

    // Simpan di session sementara
    Session::put('reset_password_data', [
        'email' => $request->email,
        'otp' => $otp,
    ]);

    try {
        Mail::raw("Kode verifikasi reset password Anda adalah: $otp.", function ($message) use ($request) {
            $message->to($request->email)->subject('Reset Password Zocco Coffee');
        });
    } catch (\Exception $e) {
        return back()->withErrors(['email' => 'Gagal mengirim email.']);
    }

    return redirect()->route('password.verify.show')->with('success', 'Kode OTP terkirim.');
}

public function showVerifyResetOtp() {
    if (!Session::has('reset_password_data')) return redirect()->route('password.request');
    return view('Verify-Reset');
}

public function verifyResetOtp(Request $request) {
    $request->validate(['otp' => 'required|numeric']);
    $sessionData = Session::get('reset_password_data');

    if ($request->otp == $sessionData['otp']) {
        Session::put('otp_verified', true);
        return redirect()->route('password.reset.show');
    }

    return back()->withErrors(['otp' => 'Kode OTP salah.']);
}

public function showResetPassword() {
    if (!Session::get('otp_verified')) return redirect()->route('password.request');
    return view('Reset-Password');
}

public function resetPassword(Request $request) {
    $request->validate([
        'password' => 'required|confirmed|min:6',
    ]);

    $sessionData = Session::get('reset_password_data');
    $user = User::where('email', $sessionData['email'])->first();
    
    $user->update([
        'password' => Hash::make($request->password)
    ]);

    Session::forget(['reset_password_data', 'otp_verified']);

    return redirect()->route('login')->with('success', 'Password berhasil diubah!');
}

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function editProfile() {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function updateProfile(Request $request) {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        $currentUser = User::find($user->id); 
        $currentUser->name = $request->name;
        $currentUser->email = $request->email;

        if ($request->filled('password')) {
            $currentUser->password = Hash::make($request->password);
        }

        $currentUser->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}