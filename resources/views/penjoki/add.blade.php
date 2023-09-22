@extends('layouts.app')
@include('layouts.partials.css')
@include('layouts.partials.js')

@section('content')

    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('admin.penjoki') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Penjoki</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.penjoki') }}">Penjoki</a></div>
            <div class="breadcrumb-item active">Tambah</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah Penjoki</h4>
                </div>
                <div class="card-body">
                    {!! Form::open(['method' => 'post', 'route' => ['admin.penjoki.store'], 'enctype' => 'multipart/form-data']) !!}
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Lengkap</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}">
                            <i class="text-danger">{{ $errors->first('nama_lengkap') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No Telp</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="number" name="no_telp" class="form-control" value="{{ old('no_telp') }}">
                            <i class="text-danger">{{ $errors->first('no_telp') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tempat Lahir</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}">
                            <i class="text-danger">{{ $errors->first('tempat_lahir') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal Lahir</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                            <i class="text-danger">{{ $errors->first('tanggal_lahir') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis Kelamin</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="jenis_kelamin" class="form-control selectric">
                                <option value="">- Pilih -</option>
                                <option value="l" @if(old('jenis_kelamin')=='l') selected @endif>Laki - Laki</option>
                                <option value="p" @if(old('jenis_kelamin')=='p') selected @endif>Perempuan</option>
                            </select>
                            <i class="text-danger">{{ $errors->first('jenis_kelamin') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Foto</label>
                        <div class="col-sm-12 col-md-7">                            
                            <div id="image-preview" class="image-preview">
                                <label for="image-upload" id="image-label">Choose File</label>
                                <input type="file" name="foto" id="image-upload" />
                            </div>
                            <i class="text-danger">{{ $errors->first('foto') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            <i class="text-danger">{{ $errors->first('email') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Password</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="password" name="password" class="form-control">
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