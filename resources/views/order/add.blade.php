@extends('layouts.app')
@include('order.partials.css')
@include('order.partials.js')

@section('content')

    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('admin.order') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Order</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.order') }}">Order</a></div>
            <div class="breadcrumb-item active">Tambah</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah Order</h4>
                </div>
                <div class="card-body">
                    {!! Form::open(['method' => 'post', 'route' => ['admin.order.store'], 'enctype' => 'multipart/form-data']) !!}
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Karyawan</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="penjoki" class="form-control select2">
                                <option value="">- Pilih -</option>
                                @foreach ($penjoki as $row)
                                    <option value="{{ $row->id }}" @if(old('penjoki')==$row->id) selected @endif>{{ $row->name }}</option>
                                @endforeach
                            </select>
                            <i class="text-danger">{{ $errors->first('penjoki') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis Order</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="jenis[]" class="form-control select2" multiple>
                                <option value="">- Pilih -</option>
                                @foreach ($jenis as $row)
                                    <option value="{{ $row->id }}" @if(old('jenis')==$row->id) selected @endif>{{ $row->judul }}</option>
                                @endforeach
                            </select>
                            <i class="text-danger">{{ $errors->first('jenis') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Bobot Order</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="bobot" class="form-control select2">
                                <option value="">- Pilih -</option>
                                @foreach ($bobot as $row)
                                    <option value="{{ $row->id }}" @if(old('bobot')==$row->id) selected @endif>{{ strtoupper($row->bobot) }}</option>
                                @endforeach
                            </select>
                            <i class="text-danger">{{ $errors->first('bobot') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Keterangan Bobot</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" name="keterangan" class="form-control" value="{{ old('keterangan') }}" placeholder="Keterangan Bobot" autocomplete="off">
                            <i class="text-danger">{{ $errors->first('keterangan') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pelanggan</label>
                        <div class="col-sm-12 col-md-7">
                            <select name="pelanggan" class="form-control select2">
                                <option value="">- Pilih -</option>
                                @foreach ($user as $row)
                                    <option value="{{ $row->id }}" @if(old('pelanggan')==$row->id) selected @endif>{{ $row->name }}</option>
                                @endforeach
                            </select>
                            <i class="text-danger">{{ $errors->first('pelanggan') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Judul</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" autocomplete="off">
                            <i class="text-danger">{{ $errors->first('judul') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deskripsi</label>
                        <div class="col-sm-12 col-md-7">
                            <textarea name="deskripsi" class="form-control summernote-simple" id="deskripsi" rows="10" autocomplete="off">{{ old('deskripsi') }}</textarea>
                            <i class="text-danger">{{ $errors->first('deskripsi') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deadline</label>
                        <div class="col-sm-12 col-md-7">
                            <input type="date" name="deadline" class="form-control" value="{{ old('deadline') }}" autocomplete="off">
                            <i class="text-danger">{{ $errors->first('deadline') }}</i>
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Total</label>
                        <div class="col-sm-12 col-md-7">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <div class="input-group-text">
                                    Rp
                                  </div>
                                </div>
                                <input type="text" name="total" class="form-control currency" value="{{ old('total') }}" autocomplete="off">
                            </div>
                            <i class="text-danger">{{ $errors->first('total') }}</i>
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

@section('script')

<script>
    var cleaveC = new Cleave('.currency', {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
    });
</script>

@endsection
