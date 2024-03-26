@extends('layouts.app')
@include('layouts.partials.css')
@include('layouts.partials.js')

@section('content')

    <div class="section-header">
        <h1>Profil</h1>
        <div class="section-header-breadcrumb">
            @if(Auth::user()->role == 'pelanggan')
                <div class="breadcrumb-item"><a href="{{ route('pelanggan.profile') }}">Profil</a></div>
            @elseif(Auth::user()->role == 'penjoki')
                <div class="breadcrumb-item"><a href="{{ route('penjoki.profile') }}">Profil</a></div>
            @endif
            <div class="breadcrumb-item active">{{ Auth::user()->name }}</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Profil</h4>
                </div>
                <div class="card-body">
                    @if(Auth::user()->role == 'pelanggan')
                        {!! Form::model($user, ['method' => 'post', 'route' => ['pelanggan.profile.update', $user->id], 'enctype' => 'multipart/form-data']) !!}
                    @elseif(Auth::user()->role == 'penjoki')
                        {!! Form::model($user, ['method' => 'post', 'route' => ['penjoki.profile.update', $user->id], 'enctype' => 'multipart/form-data']) !!}
                    @endif
                    @method('PUT')
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Lengkap</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" name="nama_lengkap" class="form-control" value="{{ $user->name }}">
                            <i class="text-danger">{{ $errors->first('nama_lengkap') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">No Telp</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="number" name="no_telp" class="form-control" value="{{ $user->profile->no_telp }}">
                            <i class="text-danger">{{ $errors->first('no_telp') }}</i>
                        </div>
                    </div>
                    @if(Auth::user()->role == 'pelanggan')
                        
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jurusan</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" name="jurusan" class="form-control" value="{{ $user->profile->jurusan }}">
                                <i class="text-danger">{{ $errors->first('jurusan') }}</i>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Daerah</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" name="daerah" class="form-control" value="{{ $user->profile->daerah }}">
                                <i class="text-danger">{{ $errors->first('daerah') }}</i>
                            </div>
                        </div>

                    @endif
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tempat Lahir</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" name="tempat_lahir" class="form-control" value="{{ $user->profile->tmpt_lahir }}">
                            <i class="text-danger">{{ $errors->first('tempat_lahir') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal Lahir</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ $user->profile->tgl_lahir }}">
                            <i class="text-danger">{{ $errors->first('tanggal_lahir') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis Kelamin</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="jenis_kelamin" class="form-control selectric">
                                <option value="">- Pilih -</option>
                                <option value="l" @if($user->profile->jns_kelamin=='l') selected @endif>Laki - Laki</option>
                                <option value="p" @if($user->profile->jns_kelamin=='p') selected @endif>Perempuan</option>
                            </select>
                            <i class="text-danger">{{ $errors->first('jenis_kelamin') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Foto Sebelumnya</label>
                        <div class="col-sm-12 col-md-7">
                            <div style="width: 250px">
                                <img src="{{ url($user->profile->foto) }}" class="w-100">
                            </div>
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
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}">
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
