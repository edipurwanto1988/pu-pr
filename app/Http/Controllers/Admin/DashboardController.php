<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UmkmProfile;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_umkm' => UmkmProfile::count(),
            'total_products' => Product::where('type', 'produk')->count(),
            'total_jasa' => Product::where('type', 'jasa')->count(),
            'pending' => UmkmProfile::where('status', 'pending')->count() + Product::where('status', 'pending')->count(),
        ];

        $latestUmkm = UmkmProfile::with('user', 'kecamatan')->orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latestUmkm'));
    }
}