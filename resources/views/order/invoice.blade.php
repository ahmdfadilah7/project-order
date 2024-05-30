@extends('layouts.app')
@include('order.partials.css')
@include('order.partials.js')

@section('content')
    <div class="section-header">
        <h1>Order</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('admin.order') }}">Order</a></div>
            <div class="breadcrumb-item">Invoice</div>
        </div>
    </div>

    <div class="section-body">
        <div class="invoice">
            <div class="invoice-print">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="invoice-title">
                            <img src="{{ url($setting->logo) }}" width="200">
                            <div class="invoice-number mt-3">#{{ $order->kode_order }}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <strong>Tagihan Kepada:</strong><br>
                                    {{ $order->pelanggan->name }}<br>
                                    {{ $order->pelanggan->profile->no_telp }}<br>
                                    {{ $order->pelanggan->email }}<br>
                                </address>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <address>
                                    <strong>Dari:</strong><br>
                                    {{ $setting->nama_website }}<br>
                                    {{ $setting->no_telp }}<br>
                                    {{ $setting->email }}<br>
                                    {!! $setting->alamat !!}
                                </address>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <address>
                                    <strong>Tanggal Order:</strong><br>
                                    {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}<br><br>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="section-title">Detail Order</div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-md">
                                <tr>
                                    <th>Judul</th>
                                    <th class="text-center">Jenis Order</th>
                                    <th class="text-center">Deadline</th>
                                    <th class="text-right">Total</th>
                                </tr>
                                <tr>
                                    <td>{{ $order->judul }}</td>
                                    <td class="text-center">
                                        @php
                                            $jenis = array();
                                            foreach ($order->jenisorder as $value) {
                                                $jenis[] = $value->jenis->judul;
                                            }
                                            echo implode(', ', $jenis);
                                        @endphp
                                    </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($order->deadline)->format('d M Y') }}
                                    </td>
                                    <td class="text-right">
                                        {{ AllHelper::rupiah($order->total) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-8">
                                <div class="section-title">Status Pembayaran</div>
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-value invoice-detail-value-lg">
                                        @if($order->payment <> '')
                                            @if($order->payment->status == 1)
                                                DP 50%
                                            @elseif($order->payment->status == 2)
                                                LUNAS
                                            @endif
                                        @else
                                            <i class="text-danger">Belum ada pembayaran</i>                                        
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 text-right">
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">Total</div>
                                    <div class="invoice-detail-value invoice-detail-value-lg">
                                        {{ AllHelper::rupiah($order->total) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-md-right">
                <div class="float-lg-left mb-lg-0 mb-3">
                    <a href="{{ route('admin.order') }}" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
                <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button>
            </div>
        </div>
    </div>
@endsection
