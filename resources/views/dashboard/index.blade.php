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
                        <h4>Order Hari ini</h4>
                    </div>
                    <div class="card-body">
                        @php
                            $totalmasuk = [];
                            foreach ($totalpemasukan as $row) {
                                $payment = \App\Models\Payment::where('order_id', $row->id)
                                    ->whereDATE('updated_at', \Carbon\Carbon::now())
                                    ->get();
                                foreach ($payment as $value) {
                                    $totalmasuk[] = $value->nominal;
                                }
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
                        <h4>Order Bulan ini</h4>
                    </div>
                    <div class="card-body">
                        @php
                            $totalbulanini = [];
                            foreach ($totalbulan as $row) {
                                $payment = \App\Models\Payment::where('order_id', $row->id)->get();
                                foreach ($payment as $value) {
                                    $totalbulanini[] = $value->nominal;
                                }
                            }
                            echo AllHelper::rupiah(array_sum($totalbulanini));
                        @endphp
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-info bg-success">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Order Tahun ini</h4>
                    </div>
                    <div class="card-body">
                        @php
                            $totaltahunini = [];
                            foreach ($totaltahun as $row) {
                                $payment = \App\Models\Payment::where('order_id', $row->id)->get();
                                foreach ($payment as $value) {
                                    $totaltahunini[] = $value->nominal;
                                }
                            }
                            echo AllHelper::rupiah(array_sum($totaltahunini));
                        @endphp
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Order</h4>
                    <div class="card-header-action">
                        <a href="#order-hariini" data-tab="summary-tab" class="btn active">Hari ini</a>
                        <a href="#order-bulanini" data-tab="summary-tab" class="btn">Bulan ini</a>
                        <a href="#order-tahunini" data-tab="summary-tab" class="btn">Tahun ini</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="summary">
                        <div class="active" data-tab-group="summary-tab" id="order-hariini">
                            <canvas id="myChart" height="180"></canvas>
                            <div class="statistic-details mt-1">
                                <div class="statistic-details-item">
                                    <div class="detail-value">
                                        @php
                                            $totalhariini = array();
                                        @endphp
                                        @foreach ($status_order as $key => $row)
                                            @php
                                                $total = \App\Models\Order::whereDate('created_at', \Carbon\Carbon::now())
                                                    ->where('status', $key)
                                                    ->count();
                                                $totalhariini[] = $total;
                                            @endphp
                                        @endforeach
                                        {{ array_sum($totalhariini) }}
                                    </div>
                                    <div class="detail-name">Total Order</div>
                                </div>
                                @foreach ($status_order as $key => $row)
                                    @php
                                        $total2 = \App\Models\Order::whereDate('created_at', \Carbon\Carbon::now())
                                            ->where('status', $key)
                                            ->count();
                                    @endphp
                                    <div class="statistic-details-item">
                                        <div class="detail-value">
                                            {{ $total2 }}
                                        </div>
                                        <div class="detail-name">{{ $row }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div data-tab-group="summary-tab" id="order-bulanini">
                            <canvas id="myChart2" height="180"></canvas>
                            <div class="statistic-details mt-1">
                                <div class="statistic-details-item">
                                    <div class="detail-value">
                                        @php
                                            $totalbulanini = array();
                                        @endphp
                                        @foreach ($status_order as $key => $row)
                                            @php
                                                $total = \App\Models\Order::whereMonth('created_at', \Carbon\Carbon::now()->format('m'))
                                                    ->where('status', $key)
                                                    ->count();
                                                $totalbulanini[] = $total;
                                            @endphp
                                        @endforeach
                                        {{ array_sum($totalbulanini) }}
                                    </div>
                                    <div class="detail-name">Total Order</div>
                                </div>
                                @foreach ($status_order as $key => $row)
                                    @php
                                        $total2 = \App\Models\Order::whereMonth('created_at', \Carbon\Carbon::now()->format('m'))
                                            ->where('status', $key)
                                            ->count();
                                    @endphp
                                    <div class="statistic-details-item">
                                        <div class="detail-value">
                                            {{ $total2 }}
                                        </div>
                                        <div class="detail-name">{{ $row }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div data-tab-group="summary-tab" id="order-tahunini">
                            <canvas id="myChart3" height="180"></canvas>
                            <div class="statistic-details mt-1">
                                <div class="statistic-details-item">
                                    <div class="detail-value">
                                        @php
                                            $totaltahunini = array();
                                        @endphp
                                        @foreach ($status_order as $key => $row)
                                            @php
                                                $total = \App\Models\Order::whereYear('created_at', \Carbon\Carbon::now()->format('Y'))
                                                    ->where('status', $key)
                                                    ->count();
                                                $totaltahunini[] = $total;
                                            @endphp
                                        @endforeach
                                        {{ array_sum($totaltahunini) }}
                                    </div>
                                    <div class="detail-name">Total Order</div>
                                </div>
                                @foreach ($status_order as $key => $row)
                                    @php
                                        $total2 = \App\Models\Order::whereYear('created_at', \Carbon\Carbon::now()->format('Y'))
                                            ->where('status', $key)
                                            ->count();
                                    @endphp
                                    <div class="statistic-details-item">
                                        <div class="detail-value">
                                            {{ $total2 }}
                                        </div>
                                        <div class="detail-name">{{ $row }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($status_order as $key => $row)
                        "{{ $row }}",
                    @endforeach
                ],
                datasets: [{
                    label: 'Jumlah',
                    data: [
                        @php
                            $totalhariini2 = array();
                        @endphp
                        @foreach ($status_order as $key => $row)
                            @php
                                $total = \App\Models\Order::whereDate('created_at', \Carbon\Carbon::now())
                                    ->where('status', $key)
                                    ->count();
                                $totalhariini2[] = $total;
                            @endphp
                            {{ $total }},
                        @endforeach
                    ],
                    borderWidth: 2,
                    backgroundColor: 'rgba(63,82,227,.8)',
                    borderWidth: 0,
                    borderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointRadius: 3.5,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            drawBorder: false,
                            color: '#f2f2f2',
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: {{ array_sum($totalhariini2) }},
                            callback: function(value, index, values) {
                                return value;
                            }
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false,
                            tickMarkLength: 15,
                        }
                    }]
                },
            }
        });

        var ctx2 = document.getElementById("myChart2").getContext('2d');
        var myChart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($status_order as $key => $row)
                        "{{ $row }}",
                    @endforeach
                ],
                datasets: [{
                    label: 'Jumlah',
                    data: [
                        @php
                            $totalbulanini2 = array();
                        @endphp
                        @foreach ($status_order as $key => $row)
                            @php
                                $totalbulan = \App\Models\Order::whereMonth('created_at', \Carbon\Carbon::now()->format('m'))
                                    ->where('status', $key)
                                    ->count();
                                $totalbulanini2[] = $total;
                            @endphp
                            {{ $totalbulan }},
                        @endforeach
                    ],
                    borderWidth: 2,
                    backgroundColor: 'rgba(63,82,227,.8)',
                    borderWidth: 0,
                    borderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointRadius: 3.5,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            drawBorder: false,
                            color: '#f2f2f2',
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: {{ array_sum($totalbulanini2) }},
                            callback: function(value, index, values) {
                                return value;
                            }
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false,
                            tickMarkLength: 15,
                        }
                    }]
                },
            }
        });

        var ctx3 = document.getElementById("myChart3").getContext('2d');
        var myChart3 = new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($status_order as $key => $row)
                        "{{ $row }}",
                    @endforeach
                ],
                datasets: [{
                    label: 'Jumlah',
                    data: [
                        @php
                            $totaltahunini2 = array();
                        @endphp
                        @foreach ($status_order as $key => $row)
                            @php
                                $totaltahun = \App\Models\Order::whereYear('created_at', \Carbon\Carbon::now()->format('Y'))
                                    ->where('status', $key)
                                    ->count();
                                $totaltahunini2[] = $total;
                            @endphp
                            {{ $totaltahun }},
                        @endforeach
                    ],
                    borderWidth: 2,
                    backgroundColor: 'rgba(63,82,227,.8)',
                    borderWidth: 0,
                    borderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointRadius: 3.5,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            drawBorder: false,
                            color: '#f2f2f2',
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: {{ array_sum($totaltahunini2) }},
                            callback: function(value, index, values) {
                                return value;
                            }
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false,
                            tickMarkLength: 15,
                        }
                    }]
                },
            }
        });
    </script>
@endsection
