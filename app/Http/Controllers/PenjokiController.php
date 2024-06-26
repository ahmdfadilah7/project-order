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

class PenjokiController extends Controller
{
    // Menampilkan halaman penjoki
    public function index()
    {
        $setting = Setting::first();

        $dataDeadline = Order::whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::whereDate('deadline', '=', Carbon::now()->addDay())->get();

        return view('penjoki.index', compact('setting', 'dataDeadline', 'dataDeadline2'));
    }

    // Proses menampilkan data penjoki dengan datatables
    public function listData()
    {
        $data = User::where('role', 'penjoki')->orderBy('name', 'asc');
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('no_telp', function($row) {
                $no_telp = $row->profile->no_telp;
                return $no_telp;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('admin.penjoki.show', $row->id).'" class="btn btn-info btn-sm mr-2 mb-2">
                        <i class="fas fa-info-circle"></i> Lihat
                    </a>';
                $btn .= '<a href="'.route('admin.penjoki.edit', $row->id).'" class="btn btn-primary btn-sm mr-2 mb-2">
                        <i class="fas fa-edit"></i> Edit
                    </a>';

                $url = "'".route('admin.penjoki.delete', $row->id)."'";
                $btn .= '<a onclick="deleteModal('.$url.')" class="btn btn-danger btn-sm text-white mr-2 mb-2">
                    <i class="fas fa-trash"></i> Hapus
                </a>';

                return $btn;
            })
            ->rawColumns(['action', 'no_telp'])
            ->make(true);

        return $datatables;
    }

    // Menampilkan halaman tambah penjoki
    public function create()
    {
        $setting = Setting::first();

        $dataDeadline = Order::whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::whereDate('deadline', '=', Carbon::now()->addDay())->get();

        return view('penjoki.add', compact('setting', 'dataDeadline', 'dataDeadline2'));
    }

    // Proses menambahkan penjoki
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required',
            'nama_panggilan' => 'required',
            'email' => 'required|email|unique:users,email',
            'no_telp' => 'required|numeric|unique:profiles,no_telp',
            'jenis_kelamin' => 'required',
            'foto' => 'mimes:jpg,jpeg,png,webp,svg',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        $user = new User;
        $user->name = $request->get('nama_lengkap');
        $user->username = $request->get('nama_panggilan');
        $user->email = $request->get('email');
        $user->role = 'penjoki';
        $user->password = Hash::make($request->get('password'));
        $user->save();

        if ($request->foto <> '') {
            $foto = $request->file('foto');
            $namafoto = 'Profile-'.str_replace(' ', '-', $request->get('nama_lengkap')).Str::random(5).'.'.$foto->extension();
            $foto->move(public_path('images/'), $namafoto);
            $fotoNama = 'images/'.$namafoto;
        } else {
            $fotoNama = NULL;
        }

        Profile::create([
            'user_id' => $user->id,
            'no_telp' => $request->get('no_telp'),
            'tmpt_lahir' => $request->get('tempat_lahir'),
            'tgl_lahir' => $request->get('tanggal_lahir'),
            'jns_kelamin' => $request->get('jenis_kelamin'),
            'foto' => $fotoNama
        ]);

        return redirect()->route('admin.penjoki')->with('berhasil', 'Berhasil menambahkan karyawan.');
    }

    // Menampilkan halaman detail penjoki
    public function show($id) {
        $setting = Setting::first();

        $dataDeadline = Order::whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::whereDate('deadline', '=', Carbon::now()->addDay())->get();

        $user = User::find($id);
        $order = Order::where('user_id', $id)->orderBy('created_at', 'desc')->get();
        $totalorder = Order::where('user_id', $id)->count();

        return view('penjoki.detail', compact('setting', 'dataDeadline', 'dataDeadline2', 'user', 'order', 'totalorder'));
    }

    // Menampilkan halaman edit penjoki
    public function edit($id)
    {
        $setting = Setting::first();

        $dataDeadline = Order::whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::whereDate('deadline', '=', Carbon::now()->addDay())->get();

        $user = User::find($id);

        return view('penjoki.edit', compact('setting', 'dataDeadline', 'dataDeadline2', 'user'));
    }

    // Proses edit penjoki
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required',
            'nama_panggilan' => 'required',
            'email' => 'required|email',
            'no_telp' => 'required|numeric',
            'foto' => 'mimes:jpg,jpeg,png,webp,svg'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        $user = User::find($id);
        $user->name = $request->get('nama_lengkap');
        $user->username = $request->get('nama_panggilan');
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
        $profile->tmpt_lahir = $request->get('tempat_lahir');
        $profile->tgl_lahir = $request->get('tanggal_lahir');
        $profile->jns_kelamin = $request->get('jenis_kelamin');
        if ($request->foto <> '') {
            File::delete($profile->foto);

            $profile->foto = $fotoNama;
        }
        $profile->save();

        return redirect()->route('admin.penjoki')->with('berhasil', 'Berhasil mengupdate karyawan.');
    }

    // Proses menghapus penjoki
    public function destroy($id)
    {
        $user = User::find($id);
        File::delete($user->profile->foto);

        $user->delete();

        return redirect()->route('admin.penjoki')->with('berhasil', 'Berhasil menghapus karyawan.');
    }
}
