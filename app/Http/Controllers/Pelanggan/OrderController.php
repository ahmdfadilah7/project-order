<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Setting;
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

        $status = array('DP 50%', 'LUNAS');

        return view('customer.order.index', compact('setting', 'status'));
    }

    // Proses menampilkan data order dengan datatables
    public function listData() {
        $data = Order::where('pelanggan_id', Auth::guard('pelanggan')->user()->id)->get();
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('penjoki', function($row) {
                return $row->user->name;
            })
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
                        $btn = '<a href="'.route('pelanggan.order.activities', $row->id).'" class="btn btn-info btn-sm mr-2 mb-2">
                                <i class="fas fa-eye"></i> '.$row->activity->judul_aktivitas.'
                            </a>';
                    } else {
                        $btn = '<span class="badge badge-danger"><i class="fas fa-exclamation-triangle"></i> Belum ada progress</span>';
                    }

                return $btn;
            })
            ->addColumn('payment', function($row) {
                if ($row->payment <> '') {
                    if ($row->payment->status == 1) {
                        $btn = '<a href="'.route('pelanggan.order.detailPayment', $row->id).'" class="btn btn-info btn-sm mr-2 mb-2">
                                <i class="fas fa-eye"></i> DP 50%
                            </a>';
                    } elseif ($row->payment->status == 2) {
                        $btn = '<a href="'.route('pelanggan.order.detailPayment', $row->id).'" class="btn btn-info btn-sm mr-2 mb-2">
                                <i class="fas fa-eye"></i> LUNAS
                            </a>';
                    } else {
                        $btn = '<a href="'.route('pelanggan.order.detailPayment', $row->id).'" class="btn btn-info btn-sm mr-2 mb-2">
                                <i class="fas fa-eye"></i> Menunggu Konfirmasi
                            </a>';
                    }
                } else {
                    $btn = '<span class="badge badge-danger"><i class="fas fa-exclamation-triangle"></i> Belum ada pembayaran</span>';
                }

                return $btn;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('pelanggan.order.detail', $row->id).'" class="btn btn-info btn-sm mr-2 mb-2" title="Lihat">
                        <i class="fas fa-eye"></i>
                    </a>';
                if ($row->payment == '') {
                    $btn .= '<a onClick="getOrder('.$row->id.')" href="#" class="btn btn-success btn-sm mr-2 mb-2" title="Bayar">
                            <i class="fas fa-money-bill"></i>
                        </a>';
                } else {
                    if ($row->payment->status <> 2) {
                        $btn .= '<a onClick="getOrder('.$row->id.')" href="#" class="btn btn-success btn-sm mr-2 mb-2" title="Pelunasan">
                            <i class="fas fa-money-bill"></i>
                        </a>';
                    }
                }

                return $btn;
            })
            ->rawColumns(['action', 'progress', 'payment', 'total', 'status', 'deadline'])
            ->make(true);

        return $datatables;
    }

    // get order
    public function getOrder($id)
    {
        $order = Order::find($id);

        return json_encode($order);
    }

    // Proses Payment
    public function payment(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:png,jpg,jpeg,svg',
            'status' => 'required'
        ],
        [
            'required' => ':attribute wajib diisi!!!',
            'mimes' => ':attribute harus berformat .png, .jpg, .jpeg'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors);
        }

        $file = $request->file('file');
        $namafile = 'BuktiPembayaran'.Str::random(5).'.'.$file->extension();
        $file->move(public_path('images/bukti_pembayaran/'), $namafile);
        $fileNama = 'images/bukti_pembayaran/'.$namafile;

        $payment = new Payment;
        $payment->order_id = $request->order_id;
        $payment->file = $fileNama;
        $payment->status = $request->status;
        $payment->save();

        $countpayment = Payment::where('order_id', $request->order_id)->count();
        if ($countpayment > 0) {
            $order = Order::find($request->order_id);
            $order->status = 1;
            $order->save();
        }

        return redirect()->route('pelanggan.order')->with('berhasil', 'Berhasil menambahkan pembayaran');
    }

    // Detail Payment
    public function show_payment($id)
    {
        $setting = Setting::first();

        $order = Order::find($id);

        return view('customer.order.detailpayment', compact('setting', 'order'));
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
