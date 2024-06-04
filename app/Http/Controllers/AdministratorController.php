<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Profile;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserAccess;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AdministratorController extends Controller
{
    // Menampilkan halaman administrator
    public function index() {
        $setting = Setting::first();

        $dataDeadline = Order::whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::whereDate('deadline', '=', Carbon::now()->addDay())->get();

        return view('administrator.index', compact('setting', 'dataDeadline', 'dataDeadline'));
    }

    // Proses menampilkan data administrator dengan datatables
    public function listData() {
        if (Auth::user()->access->access == 'Super Admin') {
            $data = User::where('role', 'admin');
        } else {
            $data = User::select('users.*')
                ->join('user_accesses', 'users.id', 'user_accesses.user_id')
                ->where('role', 'admin')
                ->where('access', '!=', 'Super Admin');
        }
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('access', function($row) {
                return $row->access->access;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('admin.administrator.edit', $row->id).'" class="btn btn-primary btn-sm mr-2 mb-2">
                            <i class="fas fa-edit"></i>
                        </a>';
                if ($row->id <> Auth::guard('admin')->user()->id) {
                    $btn .= '<a href="'.route('admin.administrator.delete', $row->id).'" class="btn btn-danger btn-sm mr-2 mb-2">
                            <i class="fas fa-trash"></i>
                        </a>';
                }

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);

        return $datatables;
    }

    // Menampilkan halaman tambah administrator
    public function create() {
        $setting = Setting::first();

        $dataDeadline = Order::whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::whereDate('deadline', '=', Carbon::now()->addDay())->get();

        $access = array('Super Admin', 'Manajer', 'Admin', 'Admin QC');

        return view('administrator.add', compact('setting', 'dataDeadline', 'dataDeadline2', 'access'));
    }

    // Proses menambahkan pelanggan
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required',
            'email' => 'required|email|unique:users,email',
            'no_telp' => 'required|numeric|unique:profiles,no_telp',
            'akses' => 'required',
            'foto' => 'mimes:jpg,jpeg,png,webp,svg',
            'password' => 'required|min:8'
        ],
        [
            'no_telp.required' => 'No Whatsapp wajib diisi!!',
            'no_telp.numeric' => 'No Whatsapp harus berupa angka!!',
            'no_telp.unique' => 'No Whatsapp sudah ada!!',
            'required' => ':attribute wajib diisi!!!',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        $user = new User;
        $user->name = $request->get('nama_lengkap');
        $user->email = $request->get('email');
        $user->role = 'admin';
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
            'jurusan' => $request->get('jurusan'),
            'daerah' => $request->get('daerah'),
            'tmpt_lahir' => $request->get('tempat_lahir'),
            'tgl_lahir' => $request->get('tanggal_lahir'),
            'jns_kelamin' => $request->get('jenis_kelamin'),
            'foto' => $fotoNama
        ]);

        $access = new UserAccess;
        $access->user_id = $user->id;
        $access->access = $request->akses;
        $access->save();

        return redirect()->route('admin.administrator')->with('berhasil', 'Berhasil menambahkan administrator.');
    }

    // Menampilkan halaman edit administrator
    public function edit($id) {
        $setting = Setting::first();

        $dataDeadline = Order::whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::whereDate('deadline', '=', Carbon::now()->addDay())->get();

        $user = User::find($id);
        $access = array('Super Admin', 'Manajer', 'Admin', 'Admin QC');

        return view('administrator.edit', compact('setting', 'dataDeadline', 'dataDeadline2', 'user', 'access'));
    }

    // Proses edit administrator
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required',
            'email' => 'required|email',
            'foto' => 'mimes:jpg,jpeg,png,webp,svg'
        ],
        [
            'no_telp.required' => 'No Whatsapp wajib diisi!!',
            'no_telp.numeric' => 'No Whatsapp harus berupa angka!!',
            'required' => ':attribute wajib diisi!!!',
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

        if ($user->access->access <> 'Super Admin') {
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
        }


        if (Auth::user()->access->access == 'Super Admin') {
            $access = UserAccess::where('user_id', $id)->first();
            $access->access = $request->akses;
            $access->save();
        }

        return back()->with('berhasil', 'Berhasil mengupdate data profil.');
    }

    // Proses menghapus administrator
    public function destroy($id) {
        $user = User::find($id);
        File::delete($user->profile->foto);

        $user->delete();

        return redirect()->route('admin.administrator')->with('berhasil', 'Berhasil menghapus administrator.');
    }
}
