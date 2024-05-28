@extends('layouts.app')
@include('layouts.partials.css')
@include('layouts.partials.js')

@section('content')

    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('admin.bobot') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Bobot</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.bobot') }}">Bobot</a></div>
            <div class="breadcrumb-item active">Edit</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Bobot</h4>
                </div>
                <div class="card-body">
                    {!! Form::model($bobot, ['method' => 'post', 'route' => ['admin.bobot.update', $bobot->id], 'enctype' => 'multipart/form-data']) !!}
                    @method('PUT')
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Bobot</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" name="bobot" class="form-control" value="{{ $bobot->bobot }}" autocomplete="off">
                            <i class="text-danger">{{ $errors->first('bobot') }}</i>
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
