@extends('layouts.app')
@include('layouts.partials.css')
@include('layouts.partials.js')

@section('content')

    <div class="section-header">
        <h1>Order</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('pelanggan.order') }}">Order</a></div>
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
                                    <th>Deadline</th>
                                    <th>Progress Project</th>
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
    @include('customer.order.partials.payment')
@endsection

@section('script')

    <script>
        $(function() {
            $('#table-1').dataTable({
                processing: true,
                serverSide: true,
                'ordering': 'true',
                ajax: {
                    url: "{{ route('pelanggan.order.list') }}",
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
                    },
                ]
            });
        });

        function getOrder(id) {
            var url = '{{ url("pelanggan/order/get_order") }}/' + id;
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var total = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.total)
                    $('#paymentModal').modal('show');
                    $('#orderId').val(data.id);
                    $('#kodeKlien').html(data.kode_klien);
                    $('#totalPembayaran').html(total);
                }
            })
        }

        var cleaveC = new Cleave('.currency', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        });

        var cleaveC2 = new Cleave('.currency2', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        });
    </script>

@endsection