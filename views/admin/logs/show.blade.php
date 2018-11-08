@extends('oxygencms::admin.layout')

@section('title', 'Activity Log Details')

@section('content')
    <div class="row mb-5">
        <div class="col-12 d-flex align-items-center">
            <h1>Activity Log Details</h1>
        </div>

        <div class="col-12">
            <p>
                <strong>Log Id:</strong> {{ $log->id }}
                <br>
                <strong>Log Description:</strong> {{ $log->description }}
            </p>
        </div>

        <div class="col-12">
            <hr>
        </div>

        <div class="col-6">
            <h2 class="h4">Subject</h2>
            <p>
                <strong>Id: </strong>{{ $log->subject_id }}
                <br>
                <strong>Model: </strong>{{ $log->subject_type }}
            </p>
        </div>

        <div class="col-6">
            <h2 class="h4">Causer</h2>
            <p>
                <strong>Id: </strong>{{ $log->causer_id }}
                <br>
                <strong>Model: </strong>{{ $log->causer_type }}
            </p>
        </div>

        <div class="col-12">
            <h2 class="h4">Changes</h2>
            <hr>
        </div>

        @foreach($log->changes as $key => $props)
            <div class="col-6">
                <h2 class="h5">{{ ucfirst($key) }}</h2>
                <p>
                @foreach($props as $prop_name => $prop_value)
                    @if(is_array($prop_value))
                        @foreach($prop_value as $prop_value_key => $prop_value_value)
                            <strong>{{ "$prop_name - $prop_value_key" }}: </strong> {{ $prop_value_value }} <br>
                        @endforeach
                    @else
                        <strong>{{ $prop_name }}: </strong> {{ $prop_value }} <br>
                    @endif
                @endforeach
                </p>
            </div>
        @endforeach
    </div>
@endsection