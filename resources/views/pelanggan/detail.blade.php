@extends('layouts.app')
@include('layouts.partials.css')
@include('layouts.partials.js')

@section('content')
    <div class="section-header">
        <h1>Pelanggan</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.pelanggan') }}">Pelanggan</a></div>
        </div>
    </div>

    <div class="section-body">
        <h2 class="section-title">{{ $user->name }}</h2>

        <div class="row mt-sm-4">
            <div class="col-12 col-md-12 col-lg-5">
                <div class="card profile-widget">
                    <div class="profile-widget-header">
                        @if($user->profile <> '')
                            @if($user->profile->foto <> '')
                                <img alt="image" src="{{ url($user->profile->foto) }}"
                                    class="rounded-circle profile-widget-picture">
                            @else
                                <img alt="image" src="{{ url('images/avatar-5.png') }}"
                                    class="rounded-circle profile-widget-picture">
                            @endif
                        @else
                            <img alt="image" src="{{ url('images/avatar-5.png') }}"
                                class="rounded-circle profile-widget-picture">
                        @endif
                        
                        <div class="profile-widget-items">
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label">Total Order</div>
                                <div class="profile-widget-item-value">{{ $totalorder }}</div>
                            </div>
                            {{-- <div class="profile-widget-item">
                                <div class="profile-widget-item-label">Followers</div>
                                <div class="profile-widget-item-value">6,8K</div>
                            </div>
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label">Following</div>
                                <div class="profile-widget-item-value">2,1K</div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="profile-widget-description">
                        <div class="profile-widget-name">
                            {{ $user->name }}
                            <div class="text-muted d-inline font-weight-normal">
                                <div class="slash"></div> {{ $user->profile->univ }}
                            </div>
                        </div>
                        <table>
                            <tr>
                                <td>Kode Klien</td>
                                <td>: {{ $user->profile->kode_klien }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>: {{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td>No Telp</td>
                                <td>: {{ $user->profile->no_telp }}</td>
                            </tr>
                            <tr>
                                <td>Univ</td>
                                <td>: {{ $user->profile->univ }}</td>
                            </tr>
                            <tr>
                                <td>Jurusan</td>
                                <td>: {{ $user->profile->jurusan }}</td>
                            </tr>
                            <tr>
                                <td>Daerah</td>
                                <td>: {{ $user->profile->daerah }}</td>
                            </tr>
                        </table>
                        <a href="{{ route('admin.pelanggan.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-7">
                <div class="card p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table-1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Klien</th>
                                    <th>Project</th>
                                    <th>Jenis</th>
                                    <th>Total</th>
                                    <th>Tanggal Order</th>
                                    <th>Deadline</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order as $key => $row)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $row->kode_klien }}</td>
                                        <td>{{ $row->judul }}</td>
                                        <td>
                                            @php
                                                $jenis = array();
                                                foreach ($row->jenisorder as $value) {
                                                    $jenis[] = $value->jenis->judul;
                                                }
                                                $jenisorder = implode(',', $jenis);
                                                echo $jenisorder;
                                            @endphp
                                        </td>
                                        <td>{{ AllHelper::rupiah($row->total); }}</td>
                                        <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($row->deadline)->format('d M Y') }}</td>
                                        <td>
                                            @if($row->status == 0)
                                                <span class="badge badge-danger"><i class="fas fa-exclamation-triangle"></i> Belum ada pembayaran</span>
                                            @elseif ($row->status == 1)
                                                <span class="badge badge-primary"><i class="ion ion-load-a"></i> Sedang diproses</span>
                                            @elseif ($row->status == 2)
                                                <span class="badge badge-success"><i class="fas fa-check"></i> Order Selesai</span>
                                            @elseif ($row->status == 3)
                                                <span class="badge badge-danger"><i class="fas ion-close"></i> Order Refund</span>
                                            @elseif ($row->status == 4)
                                                <span class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i> Menunggu Pelunasan</span>
                                            @elseif ($row->status == 5)
                                                <span class="badge badge-primary"><i class="ion ion-load-a"></i> Menunggu Konfirmasi</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
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
        $('#table-1').dataTable()
    </script>
@endsection
