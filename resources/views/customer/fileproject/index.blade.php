@extends('layouts.app')
@include('order.partials.css')
@include('order.partials.js')

@section('content')

    <div class="section-header">
        <h1>File Project</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('pelanggan.fileproject') }}">File Project</a></div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h4>File Project</h4>
                    <a href="{{ route('pelanggan.fileproject.add') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
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
                                    <th>File</th>
                                    <th>Keterangan</th>
                                    <th>Dikirim Oleh</th>
                                    <th>Tanggal</th>
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

@section('modal')
    @include('layouts.partials.deleteModal')
@endsection

@section('script')

    <script>
        $('#table-1').dataTable({
            processing: true,
            serverSide: true,
            'ordering': 'true',
            ajax: {
                url: "{{ route('pelanggan.fileproject.list') }}",
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
                    data: 'file',
                    name: 'file'
                },
                {
                    data: 'keterangan',
                    name: 'keterangan'
                },
                {
                    data: 'user',
                    name: 'user'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    </script>

@endsection