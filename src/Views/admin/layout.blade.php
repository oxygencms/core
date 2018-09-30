<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>

    <!-- Styles -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    <!-- Styles yielded from templates -->
    @yield('css')
</head>

<body>
    <div id="oxy">
        @include('oxygencms::admin.partials.sidebar')

        <div class="content-wrapper container">
            <header class="navigation">
                @include('oxygencms::admin.partials.navigation')
            </header>

            <main class="content pb-5">
                @yield('content')
            </main>

            @if(request()->is('admin'))
                <div class="o-build">
                    <h6>Powered by:</h6>
                    <h6 class="h5">
                        <i class="fab fa-laravel"></i> <strong>Laravel 5.7</strong> &
                        <i class="fab fa-vuejs"></i> <strong>VueJS 2.5</strong>
                    </h6>
                </div>
            @endif
        </div>

        <!-- vue notifications -->
        <notifications position="top right" class="mt-2"></notifications>
    </div>

    <!-- variables passed from php -->
    @include('oxygencms::admin.partials.javascript')

    <!-- main compiled javascript -->
    <script src="{{ asset('js/admin.js') }}"></script>

    <!-- scripts pushed from templates -->
    @stack('js')

    <!-- Scripts loaded from views -->
    @if($notification = session('notification'))
        <script>
            oxy.notify('{{ $notification['text'] }}', '{{ $notification['type'] }}');
        </script>
    @endif
</body>
</html>
