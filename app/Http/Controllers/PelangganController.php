<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Profile;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
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

        $dataDeadline = Order::whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::whereDate('deadline', '=', Carbon::now()->addDay())->get();

        return view('pelanggan.index', compact('setting', 'dataDeadline', 'dataDeadline2'));
    }

    // Proses menampilkan data pelanggan dengan datatables
    public function listData() {
        $data = User::where('role', 'pelanggan');
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('kode_klien', function($row) {
                return $row->profile->kode_klien;
            })
            ->addColumn('no_telp', function($row) {
                $no_telp = $row->profile->no_telp;
                return $no_telp;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('admin.pelanggan.edit', $row->id).'" class="btn btn-primary btn-sm mr-2 mb-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>';

                $url = "'".route('admin.pelanggan.delete', $row->id)."'";
                $btn .= '<a onclick="deleteModal('.$url.')" class="btn btn-danger btn-sm text-white mr-2 mb-2">
                        <i class="fas fa-trash"></i> Hapus
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

        $dataDeadline = Order::whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::whereDate('deadline', '=', Carbon::now()->addDay())->get();

        return view('pelanggan.add', compact('setting', 'dataDeadline', 'dataDeadline2'));
    }

    // Proses menambahkan pelanggan
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required',
            'email' => 'required|email|unique:users,email',
            'no_telp' => 'required|numeric|unique:profiles,no_telp',
            'jurusan' => 'required',
            'daerah' => 'required'
        ], 
        [
            'required' => ':attribute wajib diisi !!!'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        $user = new User;
        $user->name = $request->get('nama_lengkap');
        $user->email = $request->get('email');
        $user->role = 'pelanggan';
        $user->password = Hash::make('12345678');
        $user->save();

        Profile::create([
            'user_id' => $user->id,
            'no_telp' => $request->get('no_telp'),
            'univ' => $request->get('univ'),
            'jurusan' => $request->get('jurusan'),
            'daerah' => $request->get('daerah'),
            'kode_klien' => $request->get('kode_klien')
        ]);

        return redirect()->route('admin.pelanggan')->with('berhasil', 'Berhasil menambahkan pelanggan.');
    }

    // Menampilkan halaman edit pelanggan
    public function edit($id) {
        $setting = Setting::first();

        $dataDeadline = Order::whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::whereDate('deadline', '=', Carbon::now()->addDay())->get();

        $user = User::find($id);

        return view('pelanggan.edit', compact('setting', 'dataDeadline', 'dataDeadline2', 'user'));
    }

    // Proses edit pelanggan
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required',
            'email' => 'required|email',
            'no_telp' => 'required|numeric',
            'jurusan' => 'required',
            'daerah' => 'required'
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

        $profile = Profile::where('user_id', $id)->first();
        $profile->no_telp = $request->get('no_telp');
        $profile->univ = $request->get('univ');
        $profile->jurusan = $request->get('jurusan');
        $profile->daerah = $request->get('daerah');
        $profile->kode_klien = $request->get('kode_klien');
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
