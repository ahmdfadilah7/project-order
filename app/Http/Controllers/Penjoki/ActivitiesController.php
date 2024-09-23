<?php

namespace App\Http\Controllers\Penjoki;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Order;
use App\Models\User;
use App\Notifications\AllNotif;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use League\CommonMark\Extension\SmartPunct\EllipsesParser;
use Yajra\DataTables\Facades\DataTables;

class ActivitiesController extends Controller
{
    // actvities table
    public function activitiesTable($id)
    {
        $data = Activity::where('order_id', $id)
            ->where('user_id', Auth::guard('penjoki')->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
        $dataTables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('tanggal_aktivitas', function ($row) {
                $created_at = Carbon::parse($row->created_at);
                return $created_at->diffForHumans();
            })
            ->addColumn('judul_aktivitas', function ($row) {
                return $row->judul_aktivitas;
            })
            ->make(true);

        return $dataTables;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul_aktivitas' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors);
        }

        $user_id = Auth::guard('penjoki')->user()->id;
        $message = '';

        $message = $request->status !== null ? "Project selesai" : "Berhasil menambahkan Aktivitas.";

        $activities = new Activity;
        $activities->user_id = $user_id;
        $activities->order_id = $request->order_id;
        $activities->judul_aktivitas = $request->judul_aktivitas;
        $activities->status = $request->status !== null ? $request->status : 0; 
        $activities->save();

        $order = Order::find($request->order_id);
        if ($order->payment <> '') {
            if ($order->payment->status == 2) {
                if ($request->status == 1) {
                    $order->status = 5;
                } else {
                    $order->status = 1;
                }
            } else {
                if ($request->status == 1) {
                    $order->status = 4;
                } else {
                    $order->status = 1;
                }
            }
        }
        $order->save();

        $dataNotif = [
            'title' => 'Progress Project',
            'messages' => $order->user->name.' - '.$order->kode_klien.' - '.$request->judul_aktivitas.'.',
            'url' => route('admin.order.detail', $order->id),
        ];
        $admin = User::where('role', 'admin')->get();
        Notification::send($admin, new AllNotif($dataNotif));

        $dataNotif2 = [
            'title' => 'Progress Project',
            'messages' => $order->kode_klien.' - '.$request->judul_aktivitas.'.',
            'url' => route('pelanggan.order.detail', $order->id),
        ];
        $pelanggan = User::where('id', $order->pelanggan_id)->get();
        Notification::send($pelanggan, new AllNotif($dataNotif2));

        return redirect()->route('penjoki.order.detail', $activities->order_id)->with('berhasil', $message);
    }
}
