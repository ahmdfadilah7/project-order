@extends('layouts.app')
@include('project.partials.css')
@include('project.partials.js')

@section('content')

    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('admin.project') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Project</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.project') }}">Project</a></div>
            <div class="breadcrumb-item active">Edit</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Project</h4>
                </div>
                <div class="card-body">
                    {!! Form::model($project, ['method' => 'post', 'route' => ['admin.project.update', $project->id], 'enctype' => 'multipart/form-data']) !!}
                    @method('PUT')
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pelanggan</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="name" class="form-control select2">
                                <option value="">- Pilih -</option>
                                @foreach ($user as $row)
                                    <option value="{{ $row->id }}" @if($project->user_id==$row->id) selected @endif>{{ $row->name }}</option>
                                @endforeach
                            </select>
                            <i class="text-danger">{{ $errors->first('name') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Judul</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" name="judul" class="form-control" value="{{ $project->judul }}">
                            <i class="text-danger">{{ $errors->first('judul') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deskripsi</label>
                        <div class="col-sm-12 col-md-7">
                            <textarea name="deskripsi" class="form-control summernote-simple" id="deskripsi" rows="10">{{ $project->deskripsi }}</textarea>
                            <i class="text-danger">{{ $errors->first('deskripsi') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deadline</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="date" name="deadline" class="form-control" value="{{ $project->deadline }}">
                            <i class="text-danger">{{ $errors->first('deadline') }}</i>
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
