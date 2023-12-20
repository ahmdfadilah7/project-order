<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard
    public function index()
    {
        $setting = Setting::first();
        $totalproject = Project::count();
        $totalpenjoki = User::where('role', 'penjoki')->count();
        $totalpelanggan = User::where('role', 'pelanggan')->count();

        return view('customer.dashboard.index', compact('setting', 'totalproject', 'totalpenjoki', 'totalpelanggan'));
    }
}
