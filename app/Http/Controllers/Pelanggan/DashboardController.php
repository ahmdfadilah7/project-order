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
        $project = Project::where('user_id', Auth::guard('pelanggan')->user()->id)->get();
        $order = array();
        foreach ($project as $row) {
            $order[] = Order::where('project_id', $row->id)->count();
        }
        $totalorder = array_sum($order);
        $totalproject = Project::count();
        $totalpenjoki = User::where('role', 'penjoki')->count();
        $totalpelanggan = User::where('role', 'pelanggan')->count();

        return view('customer.dashboard.index', compact('setting', 'totalproject', 'totalpenjoki', 'totalpelanggan', 'totalorder'));
    }
}
