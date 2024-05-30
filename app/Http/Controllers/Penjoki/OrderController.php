<?php

namespace App\Http\Controllers\Penjoki;

use App\Helpers\AllHelper;
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

        return view('joki.order.index', compact('setting'));
    }

    // Proses menampilkan data order dengan datatables
    public function listData() {
        $data = Order::where('user_id', Auth::guard('penjoki')->user()->id)->get();
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('project', function($row) {
                return $row->judul;
            })
            ->addColumn('deadline', function($row) {
                return Carbon::parse($row->deadline)->format('d M Y');
            })
            ->addColumn('jenisorder', function($row) {
                $jenis = array();
                foreach ($row->jenisorder as $value) {
                    $jenis[] = $value->jenis->judul;
                }
                $jenisorder = implode(',', $jenis);
                return $jenisorder;
            })
            ->addColumn('bobot', function($row) {
                return strtoupper($row->bobot->bobot);
            })
            ->addColumn('status', function($row) {
                if ($row->status == 0) {
                    $status = '<span class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i> Belum dibayar</span>';
                } elseif ($row->status == 1) {
                    $status = '<span class="badge badge-primary"><i class="ion ion-load-a"></i> Sedang diproses</span>';
                }
                return $status;
            })
            ->addColumn('progress', function($row) {
                if ($row->activity <> '') {
                    $btn = '<span class="badge badge-info">'.$row->activity->judul_aktivitas.'</span>';
                } else {
                    $btn = '<span class="badge badge-danger"><i class="fas fa-exclamation-triangle"></i> Belum ada progress</span>';
                    }

                return $btn;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('penjoki.order.detail', $row->id).'" class="btn btn-info btn-sm mr-2 mb-2">
                        <i class="fas fa-eye"></i>
                    </a>';

                return $btn;
            })
            ->rawColumns(['action', 'total', 'status', 'progress', 'deadline'])
            ->make(true);

        return $datatables;
    }

    // Detail Order
    public function show($id)
    {
        $setting = Setting::first();

        $order = Order::find($id);

        $activity = Activity::where('order_id', $id)
                          ->orderBy('created_at', 'desc')
                          ->first();

        return view('joki.order.detail', compact('setting', 'order', 'activity'));
    }
}
