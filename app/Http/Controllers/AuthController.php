<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

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

    // Proses login
    public function proses_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        $email = $request->get('email');
        $password = Hash::make($request->get('password'));
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = User::where('email', $email)->first();
            if ($user->role == 'admin') {
                Auth::guard('admin')->loginUsingId($user->id);
                return redirect()->route('admin.dashboard')->with('berhasil', 'Selamat datang '.Auth::user()->name);
            } elseif ($user->role == 'penjoki') {
                Auth::guard('penjoki')->loginUsingId($user->id);
                return redirect()->route('penjoki.dashboard')->with('berhasil', 'Selamat datang '.Auth::user()->name);
            } elseif ($user->role == 'pelanggan') {
                Auth::guard('pelanggan')->loginUsingId($user->id);
                return redirect()->route('pelanggan.dashboard')->with('berhasil', 'Selamat datang '.Auth::user()->name);
            }
        } else {
            return back()->with('gagal', 'Data yang dimasukkan tidak sesuai.');
        }
    }

    // Proses logout
    public function logout($slug)
    {
        if ($slug == 'admin') {
            Cookie::forget('karyawan');
            Cookie::forget('pelanggan');
            Cookie::forget('bulan');
            Cookie::forget('bobot');
            Cookie::forget('status');
            Auth::guard('admin')->logout();
        } elseif ($slug == 'penjoki') {
            Auth::guard('penjoki')->logout();
        } elseif ($slug == 'pelanggan') {
            Auth::guard('pelanggan')->logout();
        }
        return redirect()->route('login')->with('berhasil', 'Berhasil keluar akun.');
    }
}
