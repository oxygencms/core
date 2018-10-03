@extends('oxygencms::admin.layout')

@section('title', 'Default')

@section('content')
    <div class="row">
        <div class="col-12 d-flex align-items-center mb-3">
            <h1>Default</h1>

            <div class="ml-auto d-flex justify-content-end">
                <div>
                    <a href="#" class="btn">
                        Create <i class="far fa-edit"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 text-center">
            <h2>Welcome, {{ auth()->user()->name }}!</h2>
        </div>
    </div>
@endsection