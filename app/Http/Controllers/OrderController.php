<?php

namespace App\Http\Controllers;

use App\Helpers\AllHelper;
use App\Models\Jenis;
use App\Models\Order;
use App\Models\Project;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    // Menampilkan halaman order
    public function index()
    {
        $setting = Setting::first();

        return view('order.index', compact('setting'));
    }

    // Proses menampilkan data order dengan datatables
    public function listData() {
        $data = Order::query();
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('penjoki', function($row) {
                return $row->user->name;
            })
            ->addColumn('project', function($row) {
                return $row->project->judul.' - '.$row->project->user->name;
            })
            ->addColumn('jenis', function($row) {
                return $row->jenis->judul;
            })
            ->addColumn('total', function($row) {
                return AllHelper::rupiah($row->total);
            })
            ->addColumn('status', function($row) {
                if ($row->status == 0) {
                    $status = '<span class="badge badge-warning">Belum dibayar</span>';
                } elseif ($row->status == 1) {
                    $status = '<span class="badge badge-primary">Sedang diproses</span>';
                }
                return $status;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('admin.order.edit', $row->id).'" class="btn btn-primary btn-sm mr-2 mb-2">
                            <i class="fas fa-edit"></i>
                        </a>';
                $btn .= '<a href="'.route('admin.order.delete', $row->id).'" class="btn btn-danger btn-sm mr-2 mb-2">
                        <i class="fas fa-trash"></i>
                    </a>';

                return $btn;
            })
            ->rawColumns(['action', 'total', 'status'])
            ->make(true);

        return $datatables;
    }

    // Menampilkan halaman tambah order
    public function create()
    {
        $setting = Setting::first();
        $penjoki = User::where('role', 'penjoki')->orderBy('id', 'desc')->get();
        $project = Project::orderBy('id', 'desc')->get();
        $jenis = Jenis::orderBy('id', 'desc')->get();

        return view('order.add', compact('setting', 'penjoki', 'project', 'jenis'));
    }

    // Proses menambahkan order
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'penjoki' => 'required',
            'project' => 'required',
            'jenis' => 'required',
            'total' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        Order::create([
            'user_id' => $request->get('penjoki'),
            'project_id' => $request->get('project'),
            'jenis_id' => $request->get('jenis'),
            'total' => str_replace(',', '', $request->get('total')),
            'status' => 0
        ]);

        return redirect()->route('admin.order')->with('berhasil', 'Berhasil menambahkan order baru.');
    }
}
