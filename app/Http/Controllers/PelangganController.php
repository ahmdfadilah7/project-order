<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PelangganController extends Controller
{
    // Menampilkan halaman pelanggan
    public function index() {
        $setting = Setting::first();

        return view('pelanggan.index', compact('setting'));
    }

    // Proses menampilkan data pelanggan dengan datatables
    public function listData() {
        $data = User::where('role', 'pelanggan');
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('no_telp', function($row) {
                $no_telp = $row->profile->no_telp;
                return $no_telp;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('admin.pelanggan.edit', $row->id).'" class="btn btn-primary btn-sm mr-2 mb-2">
                            <i class="fas fa-edit"></i>
                        </a>';
                $btn .= '<a href="'.route('admin.pelanggan.delete', $row->id).'" class="btn btn-danger btn-sm mr-2 mb-2">
                        <i class="fas fa-trash"></i>
                    </a>';

                return $btn;
            })
            ->rawColumns(['action', 'no_telp'])
            ->make(true);

        return $datatables;
    }

    // Menampilkan halaman tambah pelanggan
    public function create() {
        $setting = Setting::first();

        return view('pelanggan.add', compact('setting'));
    }

    // Proses menambahkan pelanggan
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required',
            'email' => 'required|email|unique:users,email',
            'no_telp' => 'required|numeric|unique:profiles,no_telp',
            'jurusan' => 'required',
            'daerah' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'foto' => 'required|mimes:jpg,jpeg,png,webp,svg',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        $user = new User;
        $user->name = $request->get('nama_lengkap');
        $user->email = $request->get('email');
        $user->role = 'pelanggan';
        $user->password = Hash::make($request->get('password'));
        $user->save();

        $foto = $request->file('foto');
        $namafoto = 'Profile-'.str_replace(' ', '-', $request->get('nama_lengkap')).Str::random(5).'.'.$foto->extension();
        $foto->move(public_path('images/'), $namafoto);
        $fotoNama = 'images/'.$namafoto;

        Profile::create([
            'user_id' => $user->id,
            'no_telp' => $request->get('no_telp'),
            'jurusan' => $request->get('jurusan'),
            'daerah' => $request->get('daerah'),
            'tmpt_lahir' => $request->get('tempat_lahir'),
            'tgl_lahir' => $request->get('tanggal_lahir'),
            'jns_kelamin' => $request->get('jenis_kelamin'),
            'foto' => $fotoNama
        ]);

        return redirect()->route('admin.pelanggan')->with('berhasil', 'Berhasil menambahkan pelanggan.');
    }

    // Menampilkan halaman edit pelanggan
    public function edit($id) {
        $setting = Setting::first();
        $user = User::find($id);

        return view('pelanggan.edit', compact('setting', 'user'));
    }

    // Proses edit pelanggan
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

        return redirect()->route('admin.pelanggan')->with('berhasil', 'Berhasil mengupdate pelanggan.');
    }

    // Proses menghapus pelanggan
    public function destroy($id) {
        $user = User::find($id);
        File::delete($user->profile->foto);

        $user->delete();

        return redirect()->route('admin.pelanggan')->with('berhasil', 'Berhasil menghapus pelanggan.');
    }
}
