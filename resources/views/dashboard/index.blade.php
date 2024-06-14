@extends('layouts.app')
@include('layouts.partials.css')
@include('layouts.partials.js')

@section('content')

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-archive"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Order</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalproject }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-warning bg-warning">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Hari ini</h4>
                    </div>
                    <div class="card-body">
                        @php
                            $totalmasuk = array();
                            foreach ($totalpemasukan as $row) {
                                $totalmasuk[] = $row->total;
                            }
                            echo AllHelper::rupiah(array_sum($totalmasuk));
                        @endphp
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-info bg-info">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Bulan ini</h4>
                    </div>
                    <div class="card-body">
                        @php
                            $totalbulanini = array();
                            foreach ($totalbulan as $row) {
                                $totalbulanini[] = $row->total;
                            }
                            echo AllHelper::rupiah(array_sum($totalbulanini));
                        @endphp
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-success bg-success">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Pelanggan</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalpelanggan }}
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4>Selamat Datang {{ Auth::user()->name }}</h4>
                </div>
            </div>
        </div>
    </div>

@endsection