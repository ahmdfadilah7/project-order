<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use App\Helpers\AllHelper;
use App\Models\Activity;
use App\Models\Bobot;
use App\Models\Group;
use App\Models\Jenis;
use App\Models\JenisOrder;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Setting;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    // Menampilkan halaman order
    public function index()
    {
        $setting = Setting::first();
        
        $status = array('DP', 'LUNAS');

        $status_order = array('Belum dibayar', 'Sedang diproses', 'Order Selesai');

        $dataDeadline = Order::whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::whereDate('deadline', '=', Carbon::now()->addDay())->get();

        return view('order.index', compact('setting', 'status', 'status_order', 'dataDeadline', 'dataDeadline2'));
    }

    // Proses menampilkan data order dengan datatables
    public function listData() {
        $data = Order::where('status', '<>', 2)->orderBy('deadline', 'asc');
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('penjoki', function($row) {
                return $row->user->name;
            })
            ->addColumn('pelanggan', function($row) {
                return $row->pelanggan->name;
            })
            ->addColumn('tanggal_order', function($row) {
                return Carbon::parse($row->created_at)->format('d M Y');
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
            ->addColumn('total', function($row) {
                return AllHelper::rupiah($row->total);
            })
            ->addColumn('progress', function($row) {
                if ($row->activity <> '') {
                    $btn = '<a href="'.route('admin.order.activities', $row->id).'" class="btn btn-info btn-sm mr-2 mb-2">
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
                        $btn = '<a href="'.route('admin.order.detailPayment', $row->id).'" class="btn btn-info btn-sm mr-2 mb-2">
                                <i class="fas fa-eye"></i> DP
                            </a>';
                    } elseif ($row->payment->status == 2) {
                        $btn = '<a href="'.route('admin.order.detailPayment', $row->id).'" class="btn btn-info btn-sm mr-2 mb-2">
                                <i class="fas fa-eye"></i> LUNAS
                            </a>';
                    } else {
                        $btn = '<a href="'.route('admin.order.detailPayment', $row->id).'" class="btn btn-info btn-sm mr-2 mb-2">
                                <i class="fas fa-eye"></i> Menunggu Konfirmasi
                            </a>';
                    }
                } else {
                    $btn = '<span class="badge badge-danger"><i class="fas fa-exclamation-triangle"></i> Belum ada pembayaran</span>';
                }

                return $btn;
            })
            ->addColumn('status', function($row) {
                if ($row->status == 0) {
                    $status = '<span class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i> Belum dibayar</span>';
                } elseif ($row->status == 1) {
                    $status = '<span class="badge badge-primary"><i class="ion ion-load-a"></i> Sedang diproses</span>';
                } elseif ($row->status == 2) {
                    $status = '<span class="badge badge-success"><i class="fas fa-check"></i> Order Selesai</span>';
                }
                return $status;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('admin.order.detail', $row->id).'" class="btn btn-info btn-sm mr-2 mb-2" title="Lihat">
                        <i class="fas fa-eye"></i> Lihat
                    </a>';
                $btn .= '<a href="'.route('admin.order.edit', $row->id).'" class="btn btn-primary btn-sm mr-2 mb-2" title="Edit">
                        <i class="fas fa-edit"></i> Edit
                    </a>';
                $btn .= '<a href="'.route('admin.order.invoice', $row->id).'" class="btn btn-warning btn-sm mr-2 mb-2" title="Invoice">
                        <i class="ion ion-document-text"></i> Invoice
                    </a>';
                if ($row->payment == '') {
                    $btn .= '<a onClick="getOrder('.$row->id.')" href="#" class="btn btn-success btn-sm mr-2 mb-2" title="Bayar">
                            <i class="fas fa-money-bill"></i> Bayar
                        </a>';
                } else {
                    if ($row->payment->status <> 2) {
                        $btn .= '<a onClick="getOrder('.$row->id.')" href="#" class="btn btn-success btn-sm mr-2 mb-2" title="Pelunasan">
                            <i class="fas fa-money-bill"></i> Bayar
                        </a>';
                    }
                }

                if ($row->status == 1) {
                    if ($row->payment <> '' &&  $row->activity <> '') {
                        if ($row->payment->status == 2 && $row->activity->status == 1) {
                            $btn .= '<a href="'.route('admin.order.selesai', $row->id).'" class="btn btn-success btn-sm mr-2 mb-2" title="Selesai">
                                    <i class="fas fa-check"></i> Selesai
                                </a>';
                        }
                    }
                }

                $url = "'".route('admin.order.delete', $row->id)."'";
                $btn .= '<a onclick="deleteModal('.$url.')" class="btn btn-danger btn-sm text-white mr-2 mb-2" title="Hapus">
                        <i class="fas fa-trash"></i> Hapus
                    </a>';

                return $btn;
            })
            ->rawColumns(['action', 'progress', 'payment', 'total', 'status', 'deadline'])
            ->make(true);

        return $datatables;
    }

    // Menampilkan halaman order
    public function data_selesai()
    {
        $setting = Setting::first();
        
        $status = array('DP 50%', 'LUNAS');

        $dataDeadline = Order::whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::whereDate('deadline', '=', Carbon::now()->addDay())->get();

        return view('order.selesai', compact('setting', 'status', 'dataDeadline', 'dataDeadline2'));
    }

    // Proses menampilkan data order dengan datatables
    public function listDataSelesai() {
        $data = Order::where('status', 2)->orderBy('deadline', 'asc');
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('penjoki', function($row) {
                return $row->user->name;
            })
            ->addColumn('pelanggan', function($row) {
                return $row->pelanggan->name;
            })
            ->addColumn('tanggal_order', function($row) {
                return Carbon::parse($row->created_at)->format('d M Y');
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
            ->addColumn('total', function($row) {
                return AllHelper::rupiah($row->total);
            })
            ->addColumn('progress', function($row) {
                if ($row->activity <> '') {
                    $btn = '<a href="'.route('admin.order.activities', $row->id).'" class="btn btn-info btn-sm mr-2 mb-2">
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
                        $btn = '<a href="'.route('admin.order.detailPayment', $row->id).'" class="btn btn-info btn-sm mr-2 mb-2">
                                <i class="fas fa-eye"></i> DP 50%
                            </a>';
                    } elseif ($row->payment->status == 2) {
                        $btn = '<a href="'.route('admin.order.detailPayment', $row->id).'" class="btn btn-info btn-sm mr-2 mb-2">
                                <i class="fas fa-eye"></i> LUNAS
                            </a>';
                    } else {
                        $btn = '<a href="'.route('admin.order.detailPayment', $row->id).'" class="btn btn-info btn-sm mr-2 mb-2">
                                <i class="fas fa-eye"></i> Menunggu Konfirmasi
                            </a>';
                    }
                } else {
                    $btn = '<span class="badge badge-danger"><i class="fas fa-exclamation-triangle"></i> Belum ada pembayaran</span>';
                }

                return $btn;
            })
            ->addColumn('status', function($row) {
                if ($row->status == 0) {
                    $status = '<span class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i> Belum dibayar</span>';
                } elseif ($row->status == 1) {
                    $status = '<span class="badge badge-primary"><i class="ion ion-load-a"></i> Sedang diproses</span>';
                } elseif ($row->status == 2) {
                    $status = '<span class="badge badge-success"><i class="fas fa-check"></i> Order Selesai</span>';
                }
                return $status;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('admin.order.detailselesai', $row->id).'" class="btn btn-info btn-sm mr-2 mb-2" title="Lihat">
                        <i class="fas fa-eye"></i> Lihat
                    </a>';
                $btn .= '<a href="'.route('admin.order.invoice', $row->id).'" class="btn btn-warning btn-sm mr-2 mb-2" title="Invoice">
                        <i class="ion ion-document-text"></i> Invoice
                    </a>';
                if ($row->payment == '') {
                    $btn .= '<a onClick="getOrder('.$row->id.')" href="#" class="btn btn-success btn-sm mr-2 mb-2" title="Bayar">
                            <i class="fas fa-money-bill"></i> Bayar
                        </a>';
                } else {
                    if ($row->payment->status <> 2) {
                        $btn .= '<a onClick="getOrder('.$row->id.')" href="#" class="btn btn-success btn-sm mr-2 mb-2" title="Pelunasan">
                            <i class="fas fa-money-bill"></i> Bayar
                        </a>';
                    }
                }

                if ($row->status == 1) {
                    if ($row->payment <> '' &&  $row->activity <> '') {
                        if ($row->payment->status == 2 && $row->activity->status == 1) {
                            $btn .= '<a href="'.route('admin.order.selesai', $row->id).'" class="btn btn-success btn-sm mr-2 mb-2" title="Selesai">
                                    <i class="fas fa-check"></i> Selesai
                                </a>';
                        }
                    }
                }

                $url = "'".route('admin.order.delete', $row->id)."'";
                $btn .= '<a onclick="deleteModal('.$url.')" class="btn btn-danger btn-sm text-white mr-2 mb-2" title="Hapus">
                        <i class="fas fa-trash"></i> Hapus
                    </a>';

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

    // Proses Export
    public function export(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dari' => 'required',
            'sampai' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors);
        }

        return (new OrderExport($request->dari, $request->sampai, $request->status))
                ->download('Laporan-Order-'.date('dmY', strtotime($request->dari)).'-'.date('dmY', strtotime($request->sampai)).'-'.Str::random(5).'.xlsx');
    }

    // Proses print
    public function print($id)
    {
        $setting = Setting::first();
        $order = Order::find($id);
        
        $formatname = 'Invoice-'.$order->kode_order;

        $data = array(
            'setting' => $setting,
            'order' => $order
        );

        view()->share('order.print', $data);
        $pdf = Pdf::loadView('order.print', $data);

        return $pdf->stream(strtoupper($formatname).'.pdf');
    }

    // Proses Payment
    public function payment(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:png,jpg,jpeg,svg',
            'status' => 'required',
            'nominal' => 'required'
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
        $payment->nominal = str_replace(',', '', $request->get('nominal'));
        $payment->status = $request->status;
        $payment->save();

        $countpayment = Payment::where('order_id', $request->order_id)->count();
        if ($countpayment > 0) {
            $order = Order::find($request->order_id);
            $order->status = 1;
            $order->save();
        }

        return redirect()->route('admin.order')->with('berhasil', 'Berhasil menambahkan pembayaran');
    }

    // Detail Order
    public function show($id)
    {
        $setting = Setting::first();

        $dataDeadline = Order::whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::whereDate('deadline', '=', Carbon::now()->addDay())->get();

        $order = Order::find($id);

        return view('order.detail', compact('setting', 'dataDeadline', 'dataDeadline2', 'order'));
    }

    // Invoice Order
    public function invoice($id)
    {
        $setting = Setting::first();

        $dataDeadline = Order::whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::whereDate('deadline', '=', Carbon::now()->addDay())->get();

        $order = Order::find($id);

        return view('order.invoice', compact('setting', 'dataDeadline', 'dataDeadline2', 'order'));
    }

    // Activity 
    public function activity($id)
    {
        $setting = Setting::first();

        $dataDeadline = Order::whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::whereDate('deadline', '=', Carbon::now()->addDay())->get();

        $order = Order::find($id);

        $activity = Activity::where('order_id', $id)
                          ->orderBy('created_at', 'asc')
                          ->get();

        return view('order.activities', compact('setting', 'dataDeadline', 'dataDeadline2', 'order', 'activity'));
    }

    // Detail Payment
    public function show_payment($id)
    {
        $setting = Setting::first();

        $dataDeadline = Order::whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::whereDate('deadline', '=', Carbon::now()->addDay())->get();

        $order = Order::find($id);

        return view('order.detailpayment', compact('setting', 'dataDeadline', 'dataDeadline2', 'order'));
    }

    // Menampilkan halaman tambah order
    public function create()
    {
        $setting = Setting::first();

        $dataDeadline = Order::whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::whereDate('deadline', '=', Carbon::now()->addDay())->get();

        $penjoki = User::where('role', 'penjoki')->orderBy('id', 'desc')->get();
        $user = User::where('role', 'pelanggan')->get();
        $jenis = Jenis::orderBy('id', 'desc')->get();
        $bobot = Bobot::orderBy('id', 'desc')->get();

        return view('order.add', compact('setting', 'dataDeadline', 'dataDeadline2', 'penjoki', 'jenis', 'bobot', 'user'));
    }

    // Proses menambahkan order
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'penjoki' => 'required',
            'pelanggan' => 'required',
            'judul' => 'required',
            'deskripsi' => 'required',
            'deadline' => 'required',
            'bobot' => 'required',
            'total' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        $pelanggan = User::find($request->pelanggan);

        $order = new Order;
        $order->kode_order = 'ORDSIP'.date('Ymd').strtoupper(Str::random(3));
        $order->user_id = $request->penjoki;
        $order->pelanggan_id = $request->pelanggan;
        $order->bobot_id = $request->bobot;
        $order->kode_klien = $pelanggan->profile->kode_klien;
        $order->judul = $request->judul;
        $order->deskripsi = $request->deskripsi;
        $order->keterangan = $request->keterangan;
        $order->deadline = $request->deadline;
        $order->total = str_replace(',', '', $request->get('total'));
        $order->status = 0;
        $order->save();

        for ($i=0; $i < count($request->jenis); $i++) { 
            $jenisorder = new JenisOrder;
            $jenisorder->order_id = $order->id;
            $jenisorder->jenis_id = $request->jenis[$i];
            $jenisorder->save();
        }

        return redirect()->route('admin.order')->with('berhasil', 'Berhasil menambahkan order baru.');
    }

    // Menampilkan halaman edit order
    public function edit($id)
    {
        $setting = Setting::first();

        $dataDeadline = Order::whereDate('deadline', '=', Carbon::now())->get();
        $dataDeadline2 = Order::whereDate('deadline', '=', Carbon::now()->addDay())->get();

        $penjoki = User::where('role', 'penjoki')->orderBy('id', 'desc')->get();
        $user = User::where('role', 'pelanggan')->get();
        $jenis = Jenis::orderBy('id', 'desc')->get();
        $bobot = Bobot::orderBy('id', 'desc')->get();

        $order = Order::find($id);

        return view('order.edit', compact('setting', 'dataDeadline', 'dataDeadline2', 'penjoki', 'jenis', 'bobot', 'user', 'order'));
    }

    // Proses mengedit order
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'penjoki' => 'required',
            'pelanggan' => 'required',
            'judul' => 'required',
            'deskripsi' => 'required',
            'deadline' => 'required',
            'bobot' => 'required',
            'total' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        $pelanggan = User::find($request->pelanggan);

        $order = Order::find($id);
        $order->user_id = $request->penjoki;
        $order->pelanggan_id = $request->pelanggan;
        $order->bobot_id = $request->bobot;
        $order->kode_klien = $pelanggan->profile->kode_klien;
        $order->judul = $request->judul;
        $order->deskripsi = $request->deskripsi;
        $order->keterangan = $request->keterangan;
        $order->deadline = $request->deadline;
        $order->total = str_replace(',', '', $request->get('total'));
        $order->save();

        return redirect()->route('admin.order')->with('berhasil', 'Berhasil mengedit order baru.');
    }

    // Proses selesai order
    public function selesai($id) 
    {
        $order = Order::find($id);
        $order->status = 2;
        $order->save();

        return redirect()->route('admin.order')->with('berhasil', 'Order diselesaikan.');
    }

    // Proses menghapus order
    public function destroy($id) 
    {
        $order = Order::find($id);
        $order->delete();

        return redirect()->route('admin.order')->with('berhasil', 'Berhasil menghapus order.');
    }
}
