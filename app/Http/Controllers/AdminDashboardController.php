<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Outlet;
use App\Models\CoffeeBean;
use App\Models\Merchandise;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function dashboardadmin()
    {
        // 1. Statistik Dasar
        $totalReservasi = Reservation::count();
        $totalOutlet = Outlet::count();
        
        $stokBijiKopi = CoffeeBean::sum('global_stock_kg');
        $stokMerchandise = Merchandise::sum('global_stock_unit');
        $totalProduk = $stokBijiKopi + $stokMerchandise;
        $totalUser = User::where('role', 'user')->count();
        // 2. Mengambil 5 reservasi terbaru
        $recentReservations = Reservation::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 3. LOGIKA GRAFIK PER BULAN
        // Mengambil jumlah reservasi per bulan untuk tahun berjalan
        $reservationsByMonth = Reservation::select(
                DB::raw('MONTH(reservation_date) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('reservation_date', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Siapkan Array Nama Bulan (Labels)
        $chartLabels = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Inisialisasi array data dengan 0 untuk setiap bulan (1-12)
        $chartData = array_fill(0, 12, 0);

        // Isi data dari database ke posisi index bulan yang sesuai
        foreach ($reservationsByMonth as $res) {
            // Index array mulai dari 0, sedangkan bulan 1-12, jadi dikurang 1
            $chartData[$res->bulan - 1] = $res->total;
        }

        // 4. Return ke View
        return view('DashboardAdmin', compact(
            'totalReservasi', 
            'totalOutlet', 
            'totalProduk', 
            'totalUser',
            'recentReservations',
            'chartLabels',
            'chartData'
        ));
    }
}