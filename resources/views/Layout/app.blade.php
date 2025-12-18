<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="min-h-screen flex flex-col font-sans bg-smoke dark:bg-dark-1 transition-colors duration-200">
    @include('Layout.header')

    <main class="flex-1 flex items-center justify-center">
        @yield('content')
    </main>

    @include('Layout.footer')
    
    <form action="{{ route('logout') }}" method="POST" id="logoutForm">
        @csrf
    </form>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.1.0/sweetalert2.all.min.js" integrity="sha512-0UUEaq/z58JSHpPgPv8bvdhHFRswZzxJUT9y+Kld5janc9EWgGEVGfWV1hXvIvAJ8MmsR5d4XV9lsuA90xXqUQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        window.APP = {
            errors: @json($errors->all()),
            success: @json(session('msgSuccess')),
            warning: @json(session('msgWarning')),
            info: @json(session('msgInfo')),
        };
    </script>
    @vite('resources/js/app.js')
</body>
</html>