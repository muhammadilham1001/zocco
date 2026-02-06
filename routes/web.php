<?php

use App\Models\Menu;
use App\Models\Category;
use App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\AdminMenuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminOutletController;
use App\Http\Controllers\AdminPesananController;
use App\Http\Controllers\DetailOutletController;
use App\Http\Controllers\AdminBeansmerController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminReservasiController;
use App\Http\Controllers\AdminManajemenDashboardController;

// --- PUBLIC ROUTES ---
Route::get('DetailMenuMadbaker', [DashboardController::class, 'detailmenu2'])->name('DetailMenuMadbaker');
Route::get('DetailMenuHeritage', [DashboardController::class, 'detailmenu3'])->name('DetailMenuHeritage');
Route::get('/outlet/{id}', [DetailOutletController::class, 'detailoulet'])->name('outlet.detail');
Route::get('/outlet/{id}/full-menu', [DetailOutletController::class, 'DetailMenu'])->name('DetailMenu');
Route::get('/products', [DashboardController::class, 'allProducts'])->name('products');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/', [DashboardController::class, 'index'])->name('home');
// --- GUEST ONLY (Hanya untuk yang BELUM login) ---
Route::middleware('guest')->group(function () {
    
    // Login dengan Throttle (10 kali percobaan per menit)
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:10,2')
        ->name('login.post');
    
    // Registrasi dengan Throttle
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])
        ->middleware('throttle:10,2')
        ->name('register.post');

    // Verifikasi OTP Registrasi dengan Throttle
    Route::get('/register/verify', [AuthController::class, 'showVerifyOtp'])->name('register.verify.show');
    Route::post('/register/verify', [AuthController::class, 'verifyOtp'])
        ->middleware('throttle:10,2')
        ->name('register.verify.post');

    // Lupa Password Flow dengan Throttle
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetOtp'])
        ->middleware('throttle:10,2')
        ->name('password.email');
    
    Route::get('/verify-reset-password', [AuthController::class, 'showVerifyResetOtp'])->name('password.verify.show');
    Route::post('/verify-reset-password', [AuthController::class, 'verifyResetOtp'])
        ->middleware('throttle:10,2')
        ->name('password.verify.post');

    Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('password.reset.show');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])
        ->middleware('throttle:10,2')
        ->name('password.update');
});

// --- AUTH REQUIRED (Hanya untuk yang SUDAH login) ---
Route::middleware('auth')->group(function () {
    
    Route::get('/admin/reservations/{id}/details', [AdminMenuController::class, 'getDetails'])->name('admin.reservations.details');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // CRUD Profil User
    Route::get('/profile', [AuthController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    // API RESERVASI
    Route::get('/get-categories/{outlet_id}', function ($outlet_id) {
        $categories = Category::where('outlet_id', $outlet_id)->get(['id', 'name']);
        return Response::json($categories);
    });

    Route::get('/api/menus', function (Request $request) {
        $outletId = $request->query('outlet_id');
        if (!$outletId) return Response::json([]);
        $menus = Menu::where('outlet_id', $outletId)->where('is_available', 1)->get();
        return Response::json($menus);
    });

    // --- KHUSUS ROLE ADMIN ---
    Route::middleware('role:admin')->group(function () {
        Route::get('dashboardadmin', [AdminDashboardController::class, 'dashboardadmin'])->name('DashboardAdmin');

        Route::prefix('admin')->group(function () {
            Route::get('/dashboard-management', [AdminManajemenDashboardController::class, 'managedashboard'])->name('ManajemenDashboard'); 
        Route::post('/hero/update', [AdminManajemenDashboardController::class, 'updateHero'])->name('hero.update');
            Route::post('/foto-store', [AdminManajemenDashboardController::class, 'storeFoto'])->name('admin.foto.store');
            Route::delete('/foto-delete/{id}', [AdminManajemenDashboardController::class, 'destroyFoto'])->name('admin.foto.delete');
            Route::post('/text-update', [AdminManajemenDashboardController::class, 'updateText'])->name('admin.text.update');
        });

        Route::get('Manajemenoutlet', [AdminOutletController::class, 'manageoutlet'])->name('Manajemenoutlet');
        Route::post('Manajemenoutlet', [AdminOutletController::class, 'store'])->name('Manajemenoutlet.store');
        Route::put('Manajemenoutlet/{outlet}', [AdminOutletController::class, 'update'])->name('Manajemenoutlet.update');
        Route::delete('Manajemenoutlet/{outlet}', [AdminOutletController::class, 'destroy'])->name('Manajemenoutlet.destroy');
        
        Route::get('manajemenkategori', [AdminCategoryController::class, 'index'])->name('ManajemenKategori');
        Route::post('manajemenkategori', [AdminCategoryController::class, 'store'])->name('ManajemenKategori.store');
        Route::put('manajemenkategori/{id}', [AdminCategoryController::class, 'update'])->name('ManajemenKategori.update');
        Route::delete('manajemenkategori/{id}', [AdminCategoryController::class, 'destroy'])->name('ManajemenKategori.destroy');

        Route::get('manajemenmenu', [AdminMenuController::class, 'manajemenmenu'])->name('ManajemenMenu');
        Route::post('manajemenmenu', [AdminMenuController::class, 'store'])->name('ManajemenMenu.store');
        Route::put('manajemenmenu/{id}', [AdminMenuController::class, 'update'])->name('ManajemenMenu.update');
        Route::delete('manajemenmenu/{id}', [AdminMenuController::class, 'destroy'])->name('ManajemenMenu.destroy');
      
        Route::get('ManajemenBeanmer', [AdminBeansmerController::class, 'managebeanmer'])->name('ManajemenBeanmer');
        Route::post('beans/store', [AdminBeansmerController::class, 'storeBean'])->name('beans.store');
        Route::put('beans/update/{id}', [AdminBeansmerController::class, 'updateBean'])->name('beans.update');
        Route::delete('beans/destroy/{id}', [AdminBeansmerController::class, 'destroyBean'])->name('beans.destroy');
        Route::post('merch/store', [AdminBeansmerController::class, 'storeMerch'])->name('merch.store');
        Route::put('merch/update/{id}', [AdminBeansmerController::class, 'updateMerch'])->name('merch.update');
        Route::delete('merch/destroy/{id}', [AdminBeansmerController::class, 'destroyMerch'])->name('merch.destroy');

        Route::get('reservation', [AdminReservasiController::class, 'reservation'])->name('Reservation');
        Route::put('/admin/reservation/payment/{id}', [AdminReservasiController::class, 'updatePaymentStatus'])->name('Reservation.updatePayment');
        Route::prefix('admin/reservation')->group(function () {
            Route::post('/store', [AdminReservasiController::class, 'store'])->name('Reservation.store');
            Route::put('/update-status/{id}', [AdminReservasiController::class, 'updateStatus'])->name('Reservation.updateStatus');
            Route::delete('/destroy/{id}', [AdminReservasiController::class, 'destroy'])->name('Reservation.destroy');
        });
        Route::get('manajemenpesanan', [AdminPesananController::class, 'manajemenpesanan'])->name('ManajemenPesanan');
    });

    // --- KHUSUS ROLE USER ---
    Route::middleware('role:user')->group(function () {
        Route::get('/reservasi', [DashboardController::class, 'reservasi'])->name('user.reservation');
        Route::post('/reservasi', [DashboardController::class, 'storeReservasi'])->middleware('throttle:5,1')->name('user.reservation.store');
        Route::delete('/reservasi/{id}', [DashboardController::class, 'destroyReservasi'])->name('user.reservation.destroy');
    });
});