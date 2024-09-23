@extends('layouts.app')
@include('layouts.partials.css')
@include('layouts.partials.js')

@section('content')

    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('pelanggan.fileproject') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>File Project</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('pelanggan.fileproject') }}">File Project</a></div>
            <div class="breadcrumb-item active">Tambah</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah File Project</h4>
                </div>
                <div class="card-body">
                    {!! Form::open(['method' => 'post', 'route' => ['pelanggan.fileproject.store'], 'enctype' => 'multipart/form-data']) !!}
                    
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Order</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="order" class="form-control select2">
                                <option value="">- Pilih -</option>
                                @foreach ($order as $row)
                                    <option value="{{ $row->id }}">{{ $row->kode_klien.' - '.$row->pelanggan->name }}</option>
                                @endforeach
                            </select>
                            <i class="text-danger">{{ $errors->first('order') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">File Project</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="file" name="file" class="form-control">
                            <i class="text-danger">{{ $errors->first('file') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Keterangan</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" name="keterangan" class="form-control" autocomplete="off">
                            <i class="text-danger">{{ $errors->first('keterangan') }}</i>
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
