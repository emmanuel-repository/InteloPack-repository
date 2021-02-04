<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'AdminLTE') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <style>
        .navbar-navy {
            background-color: #001f3f !important;
        }

        .password-icon {
            float: right;
            position: relative;
            margin: -26px 10px 0 0;
            cursor: pointer;
        }

        .swal2-radio {
            display: grid !important;
        }

    </style>
</head>
<body class="hold-transition sidebar-mini dark">

    <div class="wrapper" id="app">
        @yield('content')
    </div>

    <script src="{{ asset('js/app.js') }}" defer></script>
    {{-- <script src="https://rawgit.com/PygmySlowLoris/vue-stepper/master/dist/build.js"></script> --}}
</script>
</body>

</html>
