<?php

namespace App\Http\Controllers\Penjoki;

use App\Exports\OrderExport;
use App\Helpers\AllHelper;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Order;
use App\Models\Project;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    // Menampilkan halaman order
    public function index()
    {
        $setting = Setting::first();

        $dataDeadline = Order::where('user_id', Auth::user()->id)->whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::where('user_id', Auth::user()->id)->whereDate('deadline', '=', Carbon::now()->addDay())->get();

        return view('joki.order.index', compact('setting', 'dataDeadline', 'dataDeadline2'));
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
            ->addColumn('progress', function($row) {
                if ($row->activity <> '') {
                    if ($row->activity->status <> 1) {
                        $btn = '<span class="badge badge-info"><i class="ion ion-load-a"></i> '.$row->activity->judul_aktivitas.'</span>';
                    } else {
                        $btn = '<span class="badge badge-success"><i class="fas fa-check"></i> '.$row->activity->judul_aktivitas.'</span>';
                    }
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
            ->rawColumns(['action', 'total', 'progress', 'deadline'])
            ->make(true);

        return $datatables;
    }

    // Detail Order
    public function show($id)
    {
        $setting = Setting::first();

        $dataDeadline = Order::where('user_id', Auth::user()->id)->whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::where('user_id', Auth::user()->id)->whereDate('deadline', '=', Carbon::now()->addDay())->get();

        $order = Order::find($id);

        $activity = Activity::where('order_id', $id)
                          ->orderBy('created_at', 'desc')
                          ->first();

        return view('joki.order.detail', compact('setting', 'dataDeadline', 'dataDeadline2', 'order', 'activity'));
    }

    // Proses Export
    public function export(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dari' => 'required',
            'sampai' => 'required',
            'format' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors);
        }

        if ($request->format == 'EXCEL') {
            return (new OrderExport($request->dari, $request->sampai))
                    ->download('Laporan-Order-'.date('dmY', strtotime($request->dari)).'-'.date('dmY', strtotime($request->sampai)).'-'.Str::random(5).'.xlsx');
        } elseif ($request->format == 'PDF') {

            $setting = Setting::first();
            $order = Order::where('user_id', Auth::user()->id)
                ->where('deadline', '>=', $request->dari)
                ->where('deadline', '<=', $request->sampai)
                ->get();
            
            $formatname = 'Laporan-Order-'.date('dmY', strtotime($request->dari)).'-'.date('dmY', strtotime($request->sampai)).'-'.Str::random(5);

            $data = array(
                'setting' => $setting,
                'order' => $order
            );

            view()->share('joki.order.pdf', $data);
            $pdf = Pdf::loadView('joki.order.pdf', $data);

            return $pdf->stream(strtoupper($formatname).'.pdf');
        }
    }
}
