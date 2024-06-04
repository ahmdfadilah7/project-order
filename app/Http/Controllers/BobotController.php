<?php

namespace App\Http\Controllers;

use App\Models\Bobot;
use App\Models\Order;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BobotController extends Controller
{
    // Menampilkan halaman bobot
    public function index()
    {
        $setting = Setting::first();

        $dataDeadline = Order::whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::whereDate('deadline', '=', Carbon::now()->addDay())->get();

        return view('bobot.index', compact('setting', 'dataDeadline', 'dataDeadline2'));
    }

    // Proses menampilkan data bobot dengan datatables
    public function listData() {
        $data = Bobot::query();
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('admin.bobot.edit', $row->id).'" class="btn btn-primary btn-sm mr-2 mb-2">
                            <i class="fas fa-edit"></i>
                        </a>';
                $btn .= '<a href="'.route('admin.bobot.delete', $row->id).'" class="btn btn-danger btn-sm mr-2 mb-2">
                        <i class="fas fa-trash"></i>
                    </a>';

                return $btn;
            })
            ->rawColumns(['action', 'no_telp'])
            ->make(true);

        return $datatables;
    }

    // Menampilkan halaman tambah bobot
    public function create()
    {
        $setting = Setting::first();

        $dataDeadline = Order::whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::whereDate('deadline', '=', Carbon::now()->addDay())->get();

        return view('bobot.add', compact('setting', 'dataDeadline', 'dataDeadline2'));
    }

    // Proses tambah bobot
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bobot' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        Bobot::create([
            'bobot' => $request->get('bobot')
        ]);

        return redirect()->route('admin.bobot')->with('berhasil', 'Berhasil menambahkan bobot.');
    }

    // Menampilkan halaman edit bobot
    public function edit($id)
    {
        $setting = Setting::first();

        $dataDeadline = Order::whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::whereDate('deadline', '=', Carbon::now()->addDay())->get();

        $bobot = Bobot::find($id);

        return view('bobot.edit', compact('setting', 'dataDeadline', 'dataDeadline2', 'bobot'));
    }

    // Proses edit bobot
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'bobot' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        $bobot = Bobot::find($id);
        $bobot->bobot = $request->get('bobot');
        $bobot->save();

        return redirect()->route('admin.bobot')->with('berhasil', 'Berhasil mengupdate bobot.');
    }

    // Proses menghapus bobot
    public function destroy($id)
    {
        $bobot = Bobot::find($id);
        $bobot->delete();

        return redirect()->route('admin.bobot')->with('berhasil', 'Berhasil menghapus bobot.');
    }
}
