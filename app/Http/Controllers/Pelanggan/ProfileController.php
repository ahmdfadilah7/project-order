<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    // Menampilkan halaman profile
    public function index() {
        $setting = Setting::first();
        $user = User::find(Auth::user()->id);

        return view('profile.index', compact('setting', 'user'));
    }

    // Proses edit profile
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required',
            'email' => 'required|email',
            'no_telp' => 'required|numeric',
            'jurusan' => 'required',
            'daerah' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'foto' => 'mimes:jpg,jpeg,png,webp,svg'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        $user = User::find($id);
        $user->name = $request->get('nama_lengkap');
        $user->email = $request->get('email');
        if ($request->password <> '') {
            $user->password = Hash::make($request->get('password'));
        }
        $user->save();

        if ($request->foto <> '') {
            $foto = $request->file('foto');
            $namafoto = 'Profile-'.str_replace(' ', '-', $request->get('nama_lengkap')).Str::random(5).'.'.$foto->extension();
            $foto->move(public_path('images/'), $namafoto);
            $fotoNama = 'images/'.$namafoto;
        }

        $profile = Profile::where('user_id', $id)->first();
        $profile->no_telp = $request->get('no_telp');
        $profile->jurusan = $request->get('jurusan');
        $profile->daerah = $request->get('daerah');
        $profile->tmpt_lahir = $request->get('tempat_lahir');
        $profile->tgl_lahir = $request->get('tanggal_lahir');
        $profile->jns_kelamin = $request->get('jenis_kelamin');
        if ($request->foto <> '') {
            File::delete($profile->foto);

            $profile->foto = $fotoNama;
        }
        $profile->save();

        return redirect()->route('pelanggan.profile')->with('berhasil', 'Berhasil mengupdate profile.');
    }
}
