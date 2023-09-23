<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class JenisController extends Controller
{
    // Menampilkan halaman jenis
    public function index()
    {
        $setting = Setting::first();

        return view('jenis.index', compact('setting'));
    }

    // Proses menampilkan data jenis dengan datatables
    public function listData() {
        $data = Jenis::query();
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('admin.jenis.edit', $row->id).'" class="btn btn-primary btn-sm mr-2 mb-2">
                            <i class="fas fa-edit"></i>
                        </a>';
                $btn .= '<a href="'.route('admin.jenis.delete', $row->id).'" class="btn btn-danger btn-sm mr-2 mb-2">
                        <i class="fas fa-trash"></i>
                    </a>';

                return $btn;
            })
            ->rawColumns(['action', 'no_telp'])
            ->make(true);

        return $datatables;
    }

    // Menampilkan halaman tambah jenis
    public function create()
    {
        $setting = Setting::first();

        return view('jenis.add', compact('setting'));
    }

    // Proses tambah jenis
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        Jenis::create([
            'judul' => $request->get('judul')
        ]);

        return redirect()->route('admin.jenis')->with('berhasil', 'Berhasil menambahkan jenis.');
    }

    // Menampilkan halaman edit jenis
    public function edit($id)
    {
        $setting = Setting::first();
        $jenis = Jenis::find($id);

        return view('jenis.edit', compact('setting', 'jenis'));
    }

    // Proses edit jenis
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        $jenis = Jenis::find($id);
        $jenis->judul = $request->get('judul');
        $jenis->save();

        return redirect()->route('admin.jenis')->with('berhasil', 'Berhasil mengupdate jenis.');
    }

    // Proses menghapus jenis
    public function destroy($id)
    {
        $jenis = Jenis::find($id);
        $jenis->delete();

        return redirect()->route('admin.jenis')->with('berhasil', 'Berhasil menghapus jenis.');
    }
}
