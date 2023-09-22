<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class SettingController extends Controller
{
    // Menampilkan halaman setting
    public function index()
    {
        $setting = Setting::first();

        return view('setting.index', compact('setting'));
    }

    // Proses menampilkan data setting dengan datatables
    public function listData()
    {
        $data = Setting::query();
        $datatables = DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('logo', function($row) {
                if ($row->logo <> '') {
                    $img = '<img src="'.url($row->logo).'" width="50">';
                } else {
                    $img = '<i class="text-danger">Belum ada gambar</i>';
                }
                return $img;
            })
            ->addColumn('favicon', function($row) {
                if ($row->favicon <> '') {
                    $img = '<img src="'.url($row->favicon).'" width="50">';
                } else {
                    $img = '<i class="text-danger">Belum ada gambar</i>';
                }
                return $img;
            })
            ->addColumn('action', function($row) {
                $btn = '<a href="'.route('admin.setting.edit', $row->id).'" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>';

                return $btn;
            })
            ->rawColumns(['action', 'logo', 'favicon', 'bg_login', 'bg_register'])
            ->make(true);

        return $datatables;
    }

    // Menampilkan halaman edit setting
    public function edit($id)
    {
        $setting = Setting::find($id);

        return view('setting.edit', compact('setting'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_website' => 'required',
            'logo' => 'mimes:jpg,jpeg,png,svg,webp',
            'favicon' => 'mimes:jpg,jpeg,png,svg,webp',
        ],
        [
            'required' => ':attribute wajib diisi !!'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return back()->with('errors', $errors);
        }

        if ($request->logo <> '') {
            $logo = $request->file('logo');
            $namalogo = 'Logo-'.str_replace(' ', '-', $request->get('nama_website')).Str::random(5).'.'.$logo->extension();
            $logo->move(public_path('images/'), $namalogo);
            $logoNama = 'images/'.$namalogo;
        }

        if ($request->favicon <> '') {
            $favicon = $request->file('favicon');
            $namafavicon = 'Favicon-'.str_replace(' ', '-', $request->get('nama_website')).Str::random(5).'.'.$favicon->extension();
            $favicon->move(public_path('images/'), $namafavicon);
            $faviconNama = 'images/'.$namafavicon;
        }

        $setting = Setting::find($id);
        $setting->nama_website = $request->get('nama_website');
        if ($request->logo <> '') {
            $setting->logo = $logoNama;
        }
        if ($request->favicon <> '') {
            $setting->favicon = $faviconNama;
        }
        $setting->save();

        return redirect()->route('admin.setting')->with('berhasil', 'Berhasil mengupdate setting.');
    }
}
