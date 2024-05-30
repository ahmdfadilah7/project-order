<!DOCTYPE html>
<html>
<head>
    <title>INVOICE - {{ $order->kode_order }}</title>
</head>
<style type="text/css">
    body{
        font-family: 'Roboto Condensed', sans-serif;
    }
    .m-0{
        margin: 0px;
    }
    .p-0{
        padding: 0px;
    }
    .pt-5{
        padding-top:5px;
    }
    .mt-10{
        margin-top:10px;
    }
    .text-center{
        text-align:center !important;
    }
    .w-100{
        width: 100%;
    }
    .w-50{
        width:50%;   
    }
    .w-85{
        width:85%;   
    }
    .w-15{
        width:15%;   
    }
    .logo img{
        width:45px;
        height:45px;
        padding-top:30px;
    }
    .logo span{
        margin-left:8px;
        top:19px;
        position: absolute;
        font-weight: bold;
        font-size:25px;
    }
    .gray-color{
        color:#5D5D5D;
    }
    .text-bold{
        font-weight: bold;
    }
    .border{
        border:1px solid black;
    }
    table tr,th,td{
        border: 1px solid #d2d2d2;
        border-collapse:collapse;
        padding:7px 8px;
    }
    table tr th{
        background: #F4F4F4;
        font-size:15px;
    }
    table tr td{
        font-size:13px;
    }
    table{
        border-collapse:collapse;
    }
    .box-text p{
        line-height:10px;
    }
    .float-left{
        float:left;
    }
    .total-part{
        font-size:16px;
        line-height:12px;
    }
    .total-right p{
        padding-right:20px;
    }
    .font-bold {
        font-weight: 700;
    }
</style>
<body>
<div class="head-title">
    <h1 class="text-center m-0 p-0">{{ $setting->nama_website }}</h1>
</div>
<div class="add-detail mt-10">
    <div class="w-50 float-left mt-10">
        <p class="m-0 pt-5 text-bold w-100">Kode Order - <span class="gray-color">#{{ $order->kode_order }}</span></p>
        <p class="m-0 pt-5 text-bold w-100">Tanggal Order - <span class="gray-color">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</span></p>
    </div>
    <div style="clear: both;"></div>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">Tagihan Kepada:</th>
            <th class="w-50">Dari:</th>
        </tr>
        <tr>
            <td>
                <div class="box-text">
                    <p>{{ $order->pelanggan->name }}</p>
                    <p>{{ $order->pelanggan->profile->no_telp }}</p>
                    <p>{{ $order->pelanggan->email }}</p>
                </div>
            </td>
            <td>
                <div class="box-text">
                    <p>{{ $setting->nama_website }}</p>
                    <p>{{ $setting->no_telp }}</p>
                    <p>{{ $setting->email }}</p>
                    {!! $setting->alamat !!}
                </div>
            </td>
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

        <tr align="center">
            <td colspan="3">
                <p class="font-bold">Total</p>
            </td>
            <td>
                <p>{{ AllHelper::rupiah($order->total) }}</p>
            </td>
        </tr>
    </table>
</div>
</html>