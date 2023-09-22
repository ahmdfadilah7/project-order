<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    // Menampilkan halaman project
    public function index() {
        $setting = Setting::first();

        return view('project.index', compact('setting'));
    }

    // Menampilkan data project dengan datatables
    public function listData() {
        $data = Project::query();
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('name', function($row) {
                $name = $row->user->name;
                return $name;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('admin.project.edit', $row->id).'" class="btn btn-primary btn-sm mr-2">
                        <i class="fas fa-edit"></i>
                    </a>';
                $btn .= '<a href="'.route('admin.project.delete', $row->id).'" class="btn btn-danger btn-sm mr-2">
                    <i class="fas fa-trash"></i>
                </a>';

                return $btn;
            })
            ->rawColumns(['action', 'name'])
            ->make(true);

        return $datatables;
    }

    // Menampilkan halaman tambah project
    public function create() {
        $user = User::where('role', 'pelanggan')->get();
        $setting = Setting::first();

        return view('project.add', compact('setting', 'user'));
    }

    // Proses menambah project
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'judul' => 'required',
            'deskripsi' => 'required',
            'deadline' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        Project::create([
            'user_id' => $request->get('name'),
            'judul' => $request->get('judul'),
            'deskripsi' => $request->get('deskripsi'),
            'deadline' => $request->get('deadline')

        ]);

        return redirect()->route('admin.project')->with('berhasil', 'Berhasil menambahkan project.');
    }

    // Menampilkan halaman edit project
    public function edit($id) {
        $setting = Setting::first();
        $user = User::where('role', 'pelanggan')->get();
        $project = Project::find($id);

        return view('project.edit', compact('setting', 'user', 'project'));
    }

    // Proses edit project
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'judul' => 'required',
            'deskripsi' => 'required',
            'deadline' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors)->withInput($request->all());
        }

        $profile = Project::find($id);
        $profile->user_id = $request->get('name');
        $profile->judul = $request->get('judul');
        $profile->deskripsi = $request->get('deskripsi');
        $profile->deadline = $request->get('deadline');
        $profile->save();

        return redirect()->route('admin.project')->with('berhasil', 'Berhasil mengupdate project.');
    }

    // Proses hapus project
    public function destroy($id) {
        $project = Project::find($id);
        $project->delete();

        return redirect()->route('admin.project')->with('berhasil', 'Berhasil menghapus project');
    }
}
