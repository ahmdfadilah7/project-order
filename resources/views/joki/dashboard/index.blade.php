@extends('layouts.app')
@include('layouts.partials.css')
@include('layouts.partials.js')

@section('content')

    <div class="row">
        <div class="col-lg-6 col-sm-12 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-archive"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Order</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalorder }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-warning bg-warning">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Group</h4>
                    </div>
                    <div class="card-body">
                        {{ $totalgroup }}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4>Selamat Datang {{ Auth::user()->name }}</h4>
                </div>
            </div>
        </div>
    </div>

@endsection