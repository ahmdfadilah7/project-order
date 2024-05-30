@extends('layouts.app')
@include('order.partials.css')
@include('order.partials.js')

@section('content')

    <div class="section-header">
        <h1>Order</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.order') }}">Order</a></div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Cetak Laporan</h4>
                </div>
                <div class="card-body">
                    {!! Form::open(['method' => 'post', 'route' => ['admin.order.export']]) !!}
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
                    <a href="{{ route('admin.order.add') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th>Koder Order</th>
                                    <th>Karyawan</th>
                                    <th>Pelanggan</th>
                                    <th>Project</th>
                                    <th>Jenis</th>
                                    <th>Bobot</th>
                                    <th>Keterangan Bobot</th>
                                    <th>Total</th>
                                    <th>Tanggal Order</th>
                                    <th>Deadline</th>
                                    <th>Progress</th>
                                    <th>Pembayaran</th>
                                    <th>Status</th>
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
    @include('order.partials.payment')
@endsection

@section('script')

    <script>
        $(function() {
            $('#table-1').dataTable({
                processing: true,
                serverSide: true,
                'ordering': 'true',
                ajax: {
                    url: "{{ route('admin.order.list') }}",
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
                        data: 'kode_order',
                        name: 'kode_order'
                    },
                    {
                        data: 'penjoki',
                        name: 'penjoki'
                    },
                    {
                        data: 'pelanggan',
                        name: 'pelanggan'
                    },
                    {
                        data: 'judul',
                        name: 'judul'
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
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'tanggal_order',
                        name: 'tanggal_order'
                    },
                    {
                        data: 'deadline',
                        name: 'deadline'
                    },
                    {
                        data: 'progress',
                        name: 'progress',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'payment',
                        name: 'payment',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status'
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

        function getOrder(id) {
            var url = '{{ url("admin/order/get_order") }}/' + id;
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#paymentModal').modal('show');
                    $('#orderId').val(data.id);
                }
            })
        }
    </script>

@endsection