@extends('layouts.app')
@include('order.partials.css')
@include('order.partials.js')

@section('content')

    <div class="section-header">
        <h1>Order Selesai</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('penjoki.order.dataselesai') }}">Order Selesai</a></div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Cetak Laporan</h4>
                </div>
                <div class="card-body">
                    {!! Form::open(['method' => 'post', 'route' => ['penjoki.order.export']]) !!}
                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="">Dari</label>
                                    <input type="date" name="dari" class="form-control">
                                    <i class="text-danger">{{ $errors->first('dari') }}</i>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="">Sampai</label>
                                    <input type="date" name="sampai" class="form-control">
                                    <i class="text-danger">{{ $errors->first('sampai') }}</i>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <div class="form-group">
                                    <label for="">Format</label>
                                    <select name="format" class="form-control select2">
                                        <option value="">- Pilih -</option>
                                        <option value="PDF">PDF</option>
                                        <option value="EXCEL">EXCEL</option>
                                    </select>
                                    <i class="text-danger">{{ $errors->first('format') }}</i>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12">
                                <button type="submit" class="btn btn-info btn-block mt-4 pt-2"><i class="ion ion-archive"></i> Cetak Laporan</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h4>Order</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th>Kode Klien</th>
                                    <th>Project</th>
                                    <th>Jenis</th>
                                    <th>Bobot</th>
                                    <th>Keterangan Bobot</th>
                                    <th>Deadline</th>
                                    <th>Progress</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script>
        $(function() {
            $('#table-1').dataTable({
                processing: true,
                serverSide: true,
                'ordering': 'true',
                ajax: {
                    url: "{{ route('penjoki.order.listSelesai') }}",
                    data: function(d) {}
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'kode_klien',
                        name: 'kode_klien'
                    },
                    {
                        data: 'project',
                        name: 'project'
                    },
                    {
                        data: 'jenisorder',
                        name: 'jenisorder'
                    },
                    {
                        data: 'bobot',
                        name: 'bobot'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
                    },
                    {
                        data: 'deadline',
                        name: 'deadline'
                    },
                    {
                        data: 'progress',
                        name: 'progress'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>

@endsection