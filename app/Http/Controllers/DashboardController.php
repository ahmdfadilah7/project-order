<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Menampilkan halaman dashboard
    public function index()
    {
        $setting = Setting::first();

        return view('dashboard.index', compact('setting'));
    }
}
