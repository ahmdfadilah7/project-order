@extends('layouts.app')
@include('layouts.partials.css')
@include('layouts.partials.js')

@section('content')

    <div class="section-header">
        <h1>Setting Website</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.setting') }}">Setting Website</a></div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h4>Setting Website</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th>Nama Website</th>
                                    <th>Logo</th>
                                    <th>Favicon</th>
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
                    url: "{{ route('admin.setting.list') }}",
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
                        data: 'nama_website',
                        name: 'nama_website'
                    },                    
                    {
                        data: 'logo',
                        name: 'logo'
                    },
                    {
                        data: 'favicon',
                        name: 'favicon'
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
