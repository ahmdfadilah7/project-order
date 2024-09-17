@extends('layouts.app')
@include('layouts.partials.css')
@include('layouts.partials.js')

@section('content')
    <div class="section-header">
        <h1>Order</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('pelanggan.order') }}">Order</a></div>
            <div class="breadcrumb-item">Detail Pembayaran</div>
            <div class="breadcrumb-item active">{{ $order->judul }}</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h4>Detail Pembayaran</h4>
                </div>
                <div class="card-body">
                    <table>
                        <tr>
                            <th>Pelanggan</th>
                            <th width="20">:</th>
                            <td>{{ $order->pelanggan->name }}</td>
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
                            <th>Total</th>
                            <th width="20">:</th>
                            <td>{{ AllHelper::rupiah($order->total) }}</td>
                        </tr>
                        @php
                            $total_pembayaran = array();
                        @endphp
                        @if($order->payment <> '')
                            
                            @foreach($order->payment->where('order_id', $order->id)->get() as $key => $value)
                                @php
                                    $total_pembayaran[] = $value->nominal;
                                @endphp
                                @if($value->status == 1)
                                    <tr>
                                        <th>DP {{ ++$key }}</th>
                                        <th width="20">:</th>
                                        <td>{{ AllHelper::rupiah($value->nominal) }}</td>
                                    </tr>
                                @else
                                    <tr>
                                        <th>Pembayaran Terakhir</th>
                                        <th width="20">:</th>
                                        <td>{{ AllHelper::rupiah($value->nominal) }}</td>
                                    </tr>
                                @endif
                            @endforeach

                            @if($order->payment->status == 2)
                                <tr>
                                    <th>Total Pembayaran</th>
                                    <th width="20">:</th>
                                    <td>
                                        {{ AllHelper::rupiah(array_sum($total_pembayaran)); }}
                                    </td>
                                </tr>
                            @elseif($order->payment->status == 1)
                                <tr>
                                    <th>Sisa Pembayaran</th>
                                    <th width="20">:</th>
                                    <td>
                                        {{ AllHelper::rupiah($order->total-array_sum($total_pembayaran)); }}
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <th>Status Payment</th>
                                <th width="20">:</th>
                                <td>
                                    @if($order->payment->status == 0)
                                        <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                    @elseif($order->payment->status == 1)
                                        <span class="badge badge-primary">DP</span>
                                    @elseif($order->payment->status == 2)
                                        <span class="badge badge-success">LUNAS</span>
                                    @endif    
                                </td>
                            </tr>
                            <tr>
                                <th>Bukti Pembayaran</th>
                                <th width="20">:</th>
                                <td>
                                    <div class="gallery gallery-md" data-item-height="100">
                                        @php
                                            $payment = \App\Models\Payment::where('order_id', $order->id)->get();
                                        @endphp
                                        @foreach($payment as $key => $row)
    
                                            <div class="gallery-item" data-image="{{ url($row->file) }}" data-title="{{ $order->judul }}">
                                            </div>
    
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @else
                            <tr>
                                <th>Status Payment</th>
                                <th width="20">:</th>
                                <td>
                                    <span class="badge badge-danger">Belum ada pembayaran</span>
                                </td>
                            </tr>
                        @endif
                    </table>
                    <a href="{{ route('pelanggan.order') }}" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i>
                        Kembali</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h4>Data Pembayaran</h4>
                </div>
                <div class="card-body">
                    <a onclick="getOrder({{ $order->id }})" class="btn btn-primary text-white btn-sm mb-3"><i class="fas fa-plus"></i> Tambah</a>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Keterangan</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>

                                @if ($order->payment <> '')
                                    
                                    @foreach($order->payment->where('order_id', $order->id)->get() as $key => $value)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            @if($value->status == 1)
                                                <td>DP {{ $key }}</td>
                                            @elseif($value->status == 2)
                                                <td>Pembayaran Terakhir</td>
                                            @endif
                                            <td>{{ AllHelper::rupiah($value->nominal) }}</td>
                                        </tr>
                                    @endforeach

                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
            
    </div>
@endsection
