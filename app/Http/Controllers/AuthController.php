<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function login()
    {
        $setting = Setting::first();

        return view('auth.login', compact('setting'));
    }

    // Menampilkan halaman register
    public function register()
    {
        $setting = Setting::first();
        
        return view('auth.register', compact('setting'));
    }
}
