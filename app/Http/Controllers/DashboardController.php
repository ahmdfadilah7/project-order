<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Project;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard
    public function index()
    {
        $setting = Setting::first();
        $totalproject = Order::count();
        $totalpenjoki = User::where('role', 'penjoki')->count();
        $totalpelanggan = User::where('role', 'pelanggan')->count();

        $totalpemasukan = Order::where('updated_at', Carbon::now())->get();
        $totalbulan = Order::whereMonth('updated_at', Carbon::now()->format('m'))->get();

        
        $dataDeadline = Order::whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::whereDate('deadline', '=', Carbon::now()->addDay())->get();

        return view('dashboard.index', compact(
            'setting', 
            'dataDeadline', 
            'dataDeadline2', 
            'totalproject', 
            'totalpenjoki', 
            'totalpelanggan',
            'totalpemasukan',
            'totalbulan'
        ));
    }
}
