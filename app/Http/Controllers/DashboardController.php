<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data asli untuk KPI Cards
        $totalProducts = Product::count();
        $totalCategories = ProductCategory::count();
        $totalUsers = User::count();
        
        // Contoh logika stok kritis: Produk dengan stok di bawah 50
        $stockAlertCount = Product::where('stock', '<', 50)->count();

        // 2. Data untuk Chart (Statistik Produk Baru 7 Hari Terakhir)
        $chartData = [];
        $chartLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $chartLabels[] = $date->translatedFormat('D'); // Nama hari
            $chartData[] = Product::whereDate('created_at', $date->toDateString())->count();
        }

        // 3. Data untuk Live Feed (3 Produk terbaru yang ditambahkan)
        $recentActivities = Product::with('category')->latest()->take(3)->get();

        return view('dashboard.index', compact(
            'totalProducts',
            'totalCategories',
            'totalUsers',
            'stockAlertCount',
            'chartLabels',
            'chartData',
            'recentActivities'
        ));
    }
}