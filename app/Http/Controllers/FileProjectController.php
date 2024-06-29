<?php

namespace App\Http\Controllers;

use App\Models\FileProject;
use App\Models\Order;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class FileProjectController extends Controller
{
    // Menampilkan halaman index
    public function index()
    {
        $setting = Setting::first();

        $dataDeadline = Order::whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::whereDate('deadline', '=', Carbon::now()->addDay())->get();

        return view('fileproject.index', compact(
            'setting',
            'dataDeadline',
            'dataDeadline2'
        ));
    }

    public function listData() {
        $data = FileProject::orderBy('id', 'desc')->get();
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('kode_klien', function($row) {
                return $row->order->kode_klien;
            })
            ->addColumn('user', function($row) {
                return $row->user->name;
            })
            ->addColumn('created_at', function($row) {
                return Carbon::parse($row->created_at)->format('d M Y');
            })
            ->addColumn('file', function($row) {
                $ext = explode('.', $row->file);
                $nama = explode('/', $row->file);
                if ($ext[1] == 'jpg' || $ext[1] == 'jpeg' || $ext[1] == 'png' || $ext[1] == 'svg') {
                    $file = '<img src="'.url($row->file).'" width="80">';
                } else {
                    $file = '<a href="'.url($row->file).'">'.$nama[1].'</a>';
                }

                return $file;
            })
            ->addColumn('action', function($row) {

                $url = "'".route('admin.fileproject.delete', $row->id)."'";
                $btn = '<a onclick="deleteModal('.$url.')" class="btn btn-danger text-white btn-sm mr-2 mb-2" title="Hapus">
                        <i class="fas fa-trash"></i> Hapus
                    </a>';

                return $btn;
            })
            ->rawColumns(['action', 'file'])
            ->make(true);

        return $datatables;
    }

    // Menampilkan halaman tambah
    public function create()
    {
        $setting = Setting::first();

        $dataDeadline = Order::whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::whereDate('deadline', '=', Carbon::now()->addDay())->get();

        $order = Order::orderBy('id', 'desc')->get();

        return view('fileproject.add', compact(
            'setting',
            'dataDeadline',
            'dataDeadline2',
            'order'
        ));
    }

    // Proses tambah
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order' => 'required',
            'file' => 'required|file',
            'keterangan' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors);
        }

        $file = $request->file('file');
        $namafile = Carbon::now()->format('dmY').strtoupper(Str::random(7)).'.'.$file->extension();
        $file->move(public_path('file'), $namafile);
        $fileName = 'file/'.$namafile;

        $fileproject = new FileProject;
        $fileproject->user_id = Auth::user()->id;
        $fileproject->order_id = $request->order;
        $fileproject->file = $fileName;
        $fileproject->keterangan = $request->keterangan;
        $fileproject->save();

        return redirect()->route('admin.fileproject')->with('berhasil', 'Berhasil menambahkan file project.');
    }

    public function destroy($id)
    {
        $fileproject = FileProject::find($id);
        $fileproject->delete();

        File::delete($fileproject->file);

        return redirect()->route('admin.fileproject')->with('berhasil', 'Berhasil menghapus file project.');
    }
}
