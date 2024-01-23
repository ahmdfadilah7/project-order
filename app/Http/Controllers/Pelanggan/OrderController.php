<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Order;
use App\Models\Project;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    // Menampilkan halaman order
    public function index()
    {
        $setting = Setting::first();

        return view('customer.order.index', compact('setting'));
    }

    // Proses menampilkan data order dengan datatables
    public function listData() {
        $projects = Project::where('user_id', Auth::guard('pelanggan')->user()->id)->get();
        $project_id = array();
        foreach ($projects as $key => $value) {
            $project_id[] = $value->id;
        }
        $data = Order::whereIn('project_id', $project_id)->get();
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('penjoki', function($row) {
                return $row->user->name;
            })
            ->addColumn('project', function($row) {
                return $row->project->judul.' - '.$row->project->user->name;
            })
            ->addColumn('deadline', function($row) {
                return Carbon::parse($row->project->deadline)->format('d M Y');
            })
            ->addColumn('jenis', function($row) {
                return $row->jenis->judul;
            })
            ->addColumn('status', function($row) {
                if ($row->status == 0) {
                    $status = '<span class="badge badge-warning">Belum dibayar</span>';
                } elseif ($row->status == 1) {
                    $status = '<span class="badge badge-primary">Sedang diproses</span>';
                }
                return $status;
            })
            ->addColumn('progress', function($row) {
                    if ($row->activity <> '') {
                        $btn = '<a href="'.route('pelanggan.order.activities', $row->id).'" class="btn btn-info btn-sm mr-2 mb-2">
                                <i class="fas fa-eye"></i> '.$row->activity->judul_aktivitas.'
                            </a>';
                    } else {
                        $btn = '<span class="badge badge-danger">Belum ada progress</span>';
                    }

                return $btn;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('pelanggan.order.detail', $row->id).'" class="btn btn-info btn-sm mr-2 mb-2">
                        <i class="fas fa-eye"></i>
                    </a>';

                return $btn;
            })
            ->rawColumns(['action', 'progress', 'total', 'status', 'deadline'])
            ->make(true);

        return $datatables;
    }

    // Detail Order
    public function show($id)
    {
        $setting = Setting::first();

        $order = Order::find($id);

        return view('customer.order.detail', compact('setting', 'order'));
    }

    // Activity 
    public function activity($id)
    {
        $setting = Setting::first();

        $order = Order::find($id);

        $activity = Activity::where('order_id', $id)
                          ->orderBy('created_at', 'asc')
                          ->get();

        return view('customer.order.activities', compact('setting', 'order', 'activity'));
    }
}
