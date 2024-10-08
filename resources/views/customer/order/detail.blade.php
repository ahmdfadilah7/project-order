@extends('layouts.app')
@include('layouts.partials.css')
@include('layouts.partials.js')

@section('content')
    <div class="section-header">
        <h1>Order</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('pelanggan.order') }}">Order</a></div>
            <div class="breadcrumb-item">Detail</div>
            <div class="breadcrumb-item active">{{ $order->judul }}</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h4>Detail Project</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>Pelanggan</th>
                            <th width="20">:</th>
                            <td>{{ $order->pelanggan->name }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Order</th>
                            <th width="20">:</th>
                            <td>
                                @php
                                    $jenis = array();
                                    foreach ($order->jenisorder as $value) {
                                        $jenis[] = $value->jenis->judul;
                                    }
                                    echo implode(',', $jenis);
                                @endphp    
                            </td>
                        </tr>
                        <tr>
                            <th>Deadline</th>
                            <th width="20">:</th>
                            <td>{{ \Carbon\Carbon::parse($order->deadline)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Judul</th>
                            <th width="20">:</th>
                            <td>{{ $order->judul }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <th width="20">:</th>
                            <td>{!! $order->deskripsi !!}</td>
                        </tr>
                    </table>
                    <a href="{{ route('pelanggan.order') }}" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i>
                        Kembali</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h4>File Project</h4>
                    {{-- <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#staticBackdrop"><i
                        class="fa fa-plus"></i> Tambah</a> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th>File</th>
                                    <th>Keterangan</th>
                                    <th>Dikirim Oleh</th>
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
    @include('customer.order.partials.fileproject')
@endsection

@section('script')
    <script>
        $(function() {
            $('#table-1').dataTable({
                processing: true,
                serverSide: true,
                'ordering': 'true',
                ajax: {
                    url: "{{ route('pelanggan.fileproject.list', $order->id) }}",
                    data: function(d) {}
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
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
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endsection
