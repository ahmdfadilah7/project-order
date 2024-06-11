@extends('layouts.app')
@include('layouts.partials.css')
@include('layouts.partials.js')

@section('content')

    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('admin.pelanggan') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Pelanggan</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.pelanggan') }}">Pelanggan</a></div>
            <div class="breadcrumb-item active">Edit</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Pelanggan</h4>
                </div>
                <div class="card-body">
                    {!! Form::model($user, ['method' => 'post', 'route' => ['admin.pelanggan.update', $user->id], 'enctype' => 'multipart/form-data']) !!}
                    @method('PUT')
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Lengkap</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" name="nama_lengkap" class="form-control" value="{{ $user->name }}" autocomplete="off">
                            <i class="text-danger">{{ $errors->first('nama_lengkap') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No Telp</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="number" name="no_telp" class="form-control" value="{{ $user->profile->no_telp }}" autocomplete="off">
                            <i class="text-danger">{{ $errors->first('no_telp') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Univ</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" name="univ" class="form-control" value="{{ $user->profile->univ }}" autocomplete="off">
                            <i class="text-danger">{{ $errors->first('univ') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jurusan</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" name="jurusan" class="form-control" value="{{ $user->profile->jurusan }}" autocomplete="off">
                            <i class="text-danger">{{ $errors->first('jurusan') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Daerah</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" name="daerah" class="form-control" value="{{ $user->profile->daerah }}" autocomplete="off">
                            <i class="text-danger">{{ $errors->first('daerah') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kode Klien</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" name="kode_klien" class="form-control" value="{{ $user->profile->kode_klien }}" autocomplete="off">
                            <i class="text-danger">{{ $errors->first('kode_klien') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" autocomplete="off">
                            <i class="text-danger">{{ $errors->first('email') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Password</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="password" name="password" class="form-control">
                            <i>* Isi jika ingin mengganti password.</i>
                            @if($errors->first('password'))
                                <br>
                            @endif
                            <i class="text-danger">{{ $errors->first('password') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
