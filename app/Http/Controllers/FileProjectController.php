<?php

namespace App\Http\Controllers;

use App\Models\FileProject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class FileProjectController extends Controller
{
    public function listData($id) {
        $data = FileProject::where('order_id', $id)->get();
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('user', function($row) {
                return $row->user->name;
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
                $btn = '<a href="'.route('admin.fileproject.delete', $row->id).'" class="btn btn-danger btn-sm mr-2 mb-2">
                        <i class="fas fa-trash"></i>
                    </a>';

                return $btn;
            })
            ->rawColumns(['action', 'file'])
            ->make(true);

        return $datatables;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
        $fileproject->order_id = $request->order_id;
        $fileproject->file = $fileName;
        $fileproject->keterangan = $request->keterangan;
        $fileproject->save();

        return redirect()->route('admin.order.detail', $request->order_id)->with('berhasil', 'Berhasil menambahkan file project.');
    }

    public function destroy($id)
    {
        $fileproject = FileProject::find($id);
        $fileproject->delete();

        File::delete($fileproject->file);

        return redirect()->route('admin.order.detail', $fileproject->order_id)->with('berhasil', 'Berhasil menghapus file project.');
    }
}
