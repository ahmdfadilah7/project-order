<!DOCTYPE html>
<html>
<head>
    <title>Laporan Order</title>
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
    <h1 class="text-center m-0 p-0">Laporan Order {{ $setting->nama_website }}</h1>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100">
        <tr>
            <th>No</th>
            <th>Kode Order</th>
            <th>Karyawan</th>
            <th>Project</th>
            <th>Jenis</th>
            <th>Bobot</th>
            <th>Keterangan Bobot</th>
            <th>Deadline</th>
            <th>Progress</th>
        </tr>
        @foreach ($order as $no => $row)
            <tr>
                <td>{{ ++$no }}</td>
                <td>{{ $row->kode_order }}</td>
                <td>{{ $row->user->name }}</td>
                <td>{{ $row->judul }}</td>
                <td>
                    @php
                        $jenis = array();
                        foreach ($row->jenisorder as $value) {
                            $jenis[] = $value->jenis->judul;
                        }
                        echo implode(', ', $jenis);
                    @endphp
                </td>
                <td>{{ strtoupper($row->bobot->bobot) }}</td>
                <td>{{ strtoupper($row->keterangan) }}</td>
                <td>
                    {{ \Carbon\Carbon::parse($row->deadline)->format('d M Y') }}
                </td>
                <td>
                    @if($row->activity <> '')
                        {{ $row->activity->judul_aktivitas }}
                    @else
                        Belum ada progress
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</div>
</html>