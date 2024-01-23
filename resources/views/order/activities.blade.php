@extends('layouts.app')
@include('layouts.partials.css')
@include('layouts.partials.js')

@section('content')
    <div class="section-header">
        <h1>Order Activities</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('pelanggan.order') }}">Order</a></div>
            <div class="breadcrumb-item">Activities</div>
        </div>
    </div>
    <div class="section-body">
        <h2 class="section-title">{{ $order->project->judul }}</h2>
        <div class="row">
            <div class="col-12">
                <div class="activities">

                    @foreach($activity as $key => $row)
                        @php
                            $icon = 'ion-arrow-down-c';
                        @endphp
                        @if($key == 0)
                            @php
                                $icon = 'ion-android-radio-button-on';
                            @endphp
                        @endif
                        
                        <div class="activity">
                            <div class="activity-icon bg-primary text-white shadow-primary">
                                <i class="{{ $icon }}"></i>
                            </div>
                            <div class="activity-detail">
                                <div class="mb-2">
                                    <span class="text-job">{{ \Carbon\Carbon::parse($row->created_at)->diffForHumans() }}</span>
                                    <span class="bullet"></span>
                                    <a class="text-job" href="#">{{ $row->user->name }}</a>
                                </div>
                                <p>{{ $row->judul_aktivitas }}</p>
                            </div>
                        </div>

                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>
@endsection
