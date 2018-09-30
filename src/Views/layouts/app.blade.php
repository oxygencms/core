<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>

    @if(isset($page))
        <meta name="description" content="{{ $page->meta_description }}">
        <meta name="keywords" content="{{ $page->meta_keywords }}">
    @endif

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    @include('oxygencms::partials.header')

    <main class="container-fluid" id="app">
        @yield('content')
    </main>

    @include('oxygencms::partials.footer')

    <!-- variables passed from php -->
    @include('oxygencms::partials.javascript')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    @if($notification = session('notification'))
    <!-- alert -->
    @component('oxygencms::partials.alert')
        @slot('type'){{ $notification['type'] }}@endslot
        {{ $notification['text'] }}
    @endcomponent
    @endif

    <!-- Scripts pushed from views -->
    @stack('js')
</body>
</html>
