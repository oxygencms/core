@extends('oxygencms::admin.layout')

@section('title', 'Activity Logs')

@section('content')
    <div class="row mb-5">
        <div class="col-12 d-flex align-items-center">
            <h1>Activity Logs</h1>
        </div>

        <form action="{{ route('admin.log.index') }}" method="get" class="col-12">
            <label for="action">Action</label>
            <select id="action" name="action">
                <option name="created">created</option>
                <option name="updated">updated</option>
                <option name="deleted">deleted</option>
            </select>

            <button type="submit">Filter</button>
        </form>


        <div class="col-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Causer</th>
                    <th scope="col">Description</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>

                <tbody>
                @foreach($logs as $log)
                    <tr>
                        <th scope="row">{{ $log->id }}</th>
                        <td>{{ $log->subject_type }}</td>
                        <td>{{ $log->causer_type }}</td>
                        <td>{{ $log->description }}</td>
                        <td>{{ $log->created_at }}</td>
                        <td>
                            <a href="{{ route('admin.log.show', $log->id) }}">details</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-12">
            {{ $logs->links() }}
        </div>
    </div>
@endsection