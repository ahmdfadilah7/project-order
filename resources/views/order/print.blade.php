<!DOCTYPE html>
<html>

<head>
    <title>INVOICE - {{ $order->kode_order }}</title>
</head>
<style type="text/css">
    body {
        font-family: 'Roboto Condensed', sans-serif;
    }

    .m-0 {
        margin: 0px;
    }

    .p-0 {
        padding: 0px;
    }

    .pt-5 {
        padding-top: 5px;
    }

    .mt-10 {
        margin-top: 10px;
    }

    .text-center {
        text-align: center !important;
    }

    .w-100 {
        width: 100%;
    }

    .w-50 {
        width: 50%;
    }

    .w-85 {
        width: 85%;
    }

    .w-15 {
        width: 15%;
    }

    .logo img {
        width: 200px;
    }

    .logo span {
        margin-left: 8px;
        position: absolute;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 20px;
    }

    .text-kode-invoice {
        margin-top: 19px;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 18px;
    }

    .gray-color {
        color: #5D5D5D;
    }

    .text-bold {
        font-weight: bold;
    }

    .border {
        border: 1px solid black;
    }

    .bill-tbl tr,
    .bill-tbl th,
    .bill-tbl td {
        border: 1px solid #d2d2d2;
        border-collapse: collapse;
        padding: 7px 8px;
    }

    table tr th {
        background: #F4F4F4;
        font-size: 15px;
    }

    table tr td {
        font-size: 13px;
    }

    table {
        border-collapse: collapse;
    }

    .box-text p {
        line-height: 10px;
    }

    .float-left {
        float: left;
    }

    .total-part {
        font-size: 16px;
        line-height: 12px;
    }

    .total-right p {
        padding-right: 20px;
    }

    .font-bold {
        font-weight: 700;
    }

    .text-right {
        text-align: right;
    }
</style>

<body>
    <div class="w-100">
        <table class="w-100 no-border">
            <tr>
                <td class="w-50">
                    <span class="text-kode-invoice" style="font-size: 24px;">
                        {{ $setting->nama_website }}
                    </span>
                    <div class="box-text">
                        <p>{{ $setting->email }}</p>
                        {!! $setting->alamat !!}
                        <p>{{ $setting->no_telp }}</p>
                    </div>
                </td>
                <td class="w-50 text-right">
                    <div class="logo">
                        {{-- <img src="data:image/svg+xml;base64,<?php echo base64_encode(file_get_contents(base_path('../' . $setting->logo))); ?>"> --}}
                        <img src="data:image/svg+xml;base64,<?php echo base64_encode(file_get_contents(base_path('public/' . $setting->logo))); ?>">
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="table-section w-100 mt-10">
        <table class="table bill-tbl w-100 mt-10">
            <tr>
                <th class="w-100" style="font-size: 18px;"> INVOICE #{{ $order->kode_order }}</th>
            </tr>
        </table>
        <table class="w-100 mt-10">
            <tr>
                <td class="w-15"><strong>Kode Klien</strong></td>
                <td>{{ $order->pelanggan->profile->kode_klien }}</td>
            </tr>
            <tr>
                <td class="w-15"><strong>Nama</strong></td>
                <td>{{ $order->pelanggan->name }}</td>
            </tr>
            <tr>
                <td class="w-15"><strong>Email</strong></td>
                <td>{{ $order->pelanggan->email }}</td>
            </tr>
            <tr>
                <td class="w-15"><strong>Universitas</strong></td>
                <td>{{ $order->pelanggan->profile->univ }}</td>
            </tr>
            <tr>
                <td class="w-15"><strong>Jurusan</strong></td>
                <td>{{ $order->pelanggan->profile->jurusan }}</td>
            </tr>
            <tr>
                <td class="w-15"><strong>No Telepon</strong></td>
                <td>{{ $order->pelanggan->profile->no_telp }}</td>
            </tr>
            <tr>
                <td class="w-15"><strong>Alamat</strong></td>
                <td>{{ $order->pelanggan->profile->daerah }}</td>
            </tr>
            
        </table>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-50">Judul</th>
                <th class="w-50">Jenis Order</th>
                <th class="w-50">Deadline</th>
                <th class="w-50">Total</th>
            </tr>
    
            <tr align="center">
                <td>{{ $order->judul }}</td>
                <td>
                    @php
                        $jenis = array();
                        foreach ($order->jenisorder as $value) {
                            $jenis[] = $value->jenis->judul;
                        }
                        echo implode(', ', $jenis);
                    @endphp    
                </td>
                <td>{{ \Carbon\Carbon::parse($order->deadline)->format('d M Y') }}</td>
                <td>{{ AllHelper::rupiah($order->total) }}</td>
            </tr>
        </table>
    </div>

    <div class="table-section w-100 mt-10">
        <table class="table bill-tbl w-100 mt-10">
            <tr>
                <th class="w-100">Status Pembayaran</th>
            </tr>
            <tr class="text-center">
                <td>
                    <div class="box-text">
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
                </td>
            </tr>
        </table>
    </div>
    
    <div class="table-section w-100 mt-10">
        <table class="table bill-tbl w-100 mt-10">
            <tr>
                <th class="w-100">Total Pembayaran</th>
                @if($order->payment <> '')
                    @if($order->payment->status == 1)
                        <th class="w-100">Total DP</th>
                        <th class="w-100">Sisa Pembayaran</th>
                    @endif
                @endif
            </tr>
            <tr class="text-center">
                <td>
                    <div class="box-text">
                        {{ AllHelper::rupiah($order->total) }}
                    </div>
                </td>
                @if($order->payment <> '')
                    @if($order->payment->status == 1)
                    <td>
                        <div class="box-text">
                            {{ AllHelper::rupiah($order->payment->nominal) }}
                        </div>
                    </td>
                    <td>
                        <div class="box-text">
                            {{ AllHelper::rupiah($order->total-$order->payment->nominal) }}
                        </div>
                    </td>
                    @endif
                @endif
            </tr>
        </table>
    </div>

</html>
