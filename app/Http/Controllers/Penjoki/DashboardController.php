<?php

namespace App\Http\Controllers\Penjoki;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Order;
use App\Models\Project;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard
    public function index()
    {
        $setting = Setting::first();
        $totalorder = Order::where('user_id', Auth::user()->id)->count();
        $totalgroup = Group::where('penjoki_id', Auth::user()->id)->count();
        $totalpelanggan = User::where('role', 'pelanggan')->count();

        $dataDeadline = Order::where('user_id', Auth::user()->id)->whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::where('user_id', Auth::user()->id)->whereDate('deadline', '=', Carbon::now()->addDay())->get();

        return view('joki.dashboard.index', compact('setting', 'totalorder', 'totalgroup', 'totalpelanggan', 'dataDeadline', 'dataDeadline2'));
    }
}
