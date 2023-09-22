@extends('layouts.app')
@include('layouts.partials.css')
@include('layouts.partials.js')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4>Selamat Datang {{ Auth::user()->name }}</h4>
                </div>
            </div>
        </div>
    </div>

@endsection