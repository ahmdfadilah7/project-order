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
                                                DP
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
                                @if($order->payment <> '')
                                    @php
                                        $total_pembayaran = array();
                                    @endphp
                                    @foreach($order->payment->where('order_id', $order->id)->get() as $key => $value)
                                        @php
                                            $total_pembayaran[] = $value->nominal;
                                        @endphp
                                        @if($value->status == 1)
                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">DP {{ ++$key }}</div>
                                                <div class="invoice-detail-value invoice-detail-value-lg">
                                                    {{ AllHelper::rupiah($value->nominal) }}
                                                </div>
                                            </div>
                                        @else
                                            <div class="invoice-detail-item">
                                                <div class="invoice-detail-name">Pembayaran Terakhir</div>
                                                <div class="invoice-detail-value invoice-detail-value-lg">
                                                    {{ AllHelper::rupiah($value->nominal) }}
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                    @if($order->payment->status == 2)
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Total Pembayaran</div>
                                            <div class="invoice-detail-value invoice-detail-value-lg">
                                                {{ AllHelper::rupiah(array_sum($total_pembayaran)) }}
                                            </div>
                                        </div>
                                    @elseif($order->payment->status == 1)
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Sisa Pembayaran</div>
                                            <div class="invoice-detail-value invoice-detail-value-lg">
                                                {{ AllHelper::rupiah($order->total-array_sum($total_pembayaran)) }}
                                            </div>
                                        </div>
                                    @endif

                                @endif

                                {{-- <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">Total</div>
                                    <div class="invoice-detail-value invoice-detail-value-lg">
                                        {{ AllHelper::rupiah($order->total) }}
                                    </div>
                                </div> --}}
                                
                                {{-- @if($order->payment <> '')

                                    @if($order->payment->status == 1)

                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Total DP</div>
                                            <div class="invoice-detail-value invoice-detail-value-lg">
                                                {{ AllHelper::rupiah($order->payment->nominal) }}
                                            </div>
                                        </div>
                                
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Sisa Pembayaran</div>
                                            <div class="invoice-detail-value invoice-detail-value-lg">
                                                {{ AllHelper::rupiah($order->total-$order->payment->nominal) }}
                                            </div>
                                        </div>
                                    @endif
                                @endif --}}

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
                @php
                    $nomor = $order->pelanggan->profile->no_telp;
                    if (substr($nomor,0,1) == 0) {
                        $no_telp = '62'.substr($nomor, 1);
                    } else {
                        $no_telp = $nomor;
                    }
                @endphp
                <a href="https://web.whatsapp.com/send?phone={{ $no_telp }}&text=*Halo ka {{ $order->pelanggan->name }}!* %0a%0aBerikut admin berikan info pembayaran: %0aNomor Invoice *{{ $order->kode_order }}* %0a%0a {{ route('print', $order->kode_order) }} %0a%0a Silahkan klik link tersebut untuk melihat status orderan secara real time. %0a%0a Boleh dibantu check apakah invoice orderan dan totalannya sudah sesuai atau belum. %0a%0a Thanks for order with us @sip_solutionintanprima" 
                    class="btn btn-info btn-icon btn-sm icon-left"><i class="fas fa-share"></i> Bagikan</a>
                <a href="{{ route('admin.order.print', $order->id) }}" class="btn btn-warning btn-icon btn-sm icon-left"><i class="fas fa-print"></i> Print</a>
            </div>
        </div>
    </div>
@endsection
