<?php

namespace App\Http\Controllers;

use App\Helpers\AllHelper;
use App\Models\Activity;
use App\Models\Group;
use App\Models\Jenis;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Setting;
use App\Models\User;
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
        
        $status = array('DP 50%', 'LUNAS');

        return view('order.index', compact('setting', 'status'));
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
            ->addColumn('deadline', function($row) {
                return Carbon::parse($row->project->deadline)->format('d M Y');
            })
            ->addColumn('jenis', function($row) {
                return $row->jenis->judul;
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
                    $btn = '<span class="badge badge-danger">Belum ada progress</span>';
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
                    $btn = '<span class="badge badge-danger">Belum ada pembayaran</span>';
                }

                return $btn;
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
                $btn = '<a href="'.route('admin.order.detail', $row->id).'" class="btn btn-info btn-sm mr-2 mb-2" title="Lihat">
                        <i class="fas fa-eye"></i>
                    </a>';
                if ($row->payment->status <> 2) {
                    $btn .= '<a onClick="getOrder('.$row->id.')" href="#" class="btn btn-success btn-sm mr-2 mb-2" title="Bayar">
                            <i class="fas fa-money-bill"></i>
                        </a>';
                }
                $btn .= '<a href="'.route('admin.order.delete', $row->id).'" class="btn btn-danger btn-sm mr-2 mb-2" title="Hapus">
                        <i class="fas fa-trash"></i>
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
        if ($countpayment < 1) {
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

        $order = Order::find($id);

        return view('order.detail', compact('setting', 'order'));
    }

    // Activity 
    public function activity($id)
    {
        $setting = Setting::first();

        $order = Order::find($id);

        $activity = Activity::where('order_id', $id)
                          ->orderBy('created_at', 'asc')
                          ->get();

        return view('order.activities', compact('setting', 'order', 'activity'));
    }

    // Detail Payment
    public function show_payment($id)
    {
        $setting = Setting::first();

        $order = Order::find($id);

        return view('order.detailpayment', compact('setting', 'order'));
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

        $project = Project::find($request->project);
        
        $nama_group = 'CL-'.substr($project->user->name, 0, 1).date('m').strtoupper(Str::random(3));
        
        $group = new Group;
        $group->name = $nama_group;
        $group->pelanggan_id = $project->user_id;
        $group->penjoki_id = $request->penjoki;
        $group->save();

        Order::create([
            'user_id' => $request->get('penjoki'),
            'project_id' => $request->get('project'),
            'jenis_id' => $request->get('jenis'),
            'total' => str_replace(',', '', $request->get('total')),
            'status' => 0
        ]);

        return redirect()->route('admin.order')->with('berhasil', 'Berhasil menambahkan order baru.');
    }

    // Proses menghapus order
    public function destroy($id) 
    {
        $order = Order::find($id);
        $order->delete();

        return redirect()->route('admin.order')->with('berhasil', 'Berhasil menghapus order.');
    }
}
