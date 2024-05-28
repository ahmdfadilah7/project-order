<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Project;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard
    public function index()
    {
        $setting = Setting::first();
        $order = Order::where('pelanggan_id', Auth::guard('pelanggan')->user()->id)->count();
        
        $totalorder = $order;
        $totalproject = Project::count();
        $totalpenjoki = User::where('role', 'penjoki')->count();
        $totalpelanggan = User::where('role', 'pelanggan')->count();

        return view('customer.dashboard.index', compact('setting', 'totalproject', 'totalpenjoki', 'totalpelanggan', 'totalorder'));
    }
}
