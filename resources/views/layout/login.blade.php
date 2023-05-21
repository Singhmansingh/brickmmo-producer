<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>My Reporter</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{url('app.css')}}">
    <script src="{{url('app.js')}}"></script>
</head>
</div>
<body class="flex flex-col items-center justify-center h-screen gap-4">
    <h1 class="text-3xl flex-shrink block">BrickMMO Radio Producer Login</h1>
    <div class="flex-shrink">
        @yield ('content')

    </div>
</body>
</html>
