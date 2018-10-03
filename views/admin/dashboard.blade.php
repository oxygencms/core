@extends('oxygencms::admin.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="row mb-5">
        <div class="col-12 d-flex align-items-center">
            <h1>Dashboard</h1>
        </div>

        <div class="col-12">
            <bar-chart :height="100"></bar-chart>
        </div>
        <div class="col-12">
            <horizontal-bar-chart :height="100"></horizontal-bar-chart>
        </div>
        <div class="col-12">
            <line-chart :height="100"></line-chart>
        </div>
        <div class="col-12">
            <pie-chart :height="100"></pie-chart>
        </div>
        <div class="col-12">
            <doughnut-chart :height="100"></doughnut-chart>
        </div>
    </div>
@endsection