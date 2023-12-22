<?php

namespace App\Http\Controllers\Penjoki;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ActivitiesController extends Controller
{
    // actvities table
    public function activitiesTable($id)
    {
        $data = Activity::where('project_id', $id)
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
        $activities->project_id = $request->project_id;
        $activities->judul_aktivitas = $request->judul_aktivitas;
        $activities->status = $request->status !== null ? $request->status : 0; 
        $activities->save();

        return redirect()->route('penjoki.order.detail', $request->project_id)->with('berhasil', $message);
    }
}
