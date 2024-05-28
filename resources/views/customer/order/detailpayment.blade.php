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
                            <th>Status Payment</th>
                            <th width="20">:</th>
                            <td>
                                @if ($order->payment->status == 0)
                                    <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                @elseif($order->payment->status == 1)
                                    <span class="badge badge-primary">DP 50%</span>
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
                    </table>
                    <a href="{{ route('pelanggan.order') }}" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i>
                        Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection
