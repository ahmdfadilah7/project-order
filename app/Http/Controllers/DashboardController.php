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

        $totalpemasukan = Order::whereDate('updated_at', Carbon::now())
            ->where('status', 2)
            ->orWhere('status', 4)
            ->orWhere('status', 5)
            ->get();
        $totalbulan = Order::whereMonth('updated_at', Carbon::now()->format('m'))
            ->where('status', 2)
            ->orWhere('status', 4)
            ->orWhere('status', 5)
            ->get();
        $totaltahun = Order::whereYear('updated_at', Carbon::now()->format('Y'))
            ->where('status', 2)
            ->orWhere('status', 4)
            ->orWhere('status', 5)
            ->get();

        $status_order = array(
            0 => 'Belum ada pembayaran', 
            1 => 'Sedang diproses', 
            4 => 'Menunggu Pelunasan', 
            5 => 'Menunggu Konfirmasi',
            2 => 'Order Selesai',
            3 => 'Order Refund'
        );

        
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
            'totalbulan',
            'totaltahun',
            'status_order'
        ));
    }
}
