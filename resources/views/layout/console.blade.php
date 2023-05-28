<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>My Reporter</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{url('app.css')}}">
    <script type="module" src="{{mix('resources/js/app.js')}}"></script>
    <script src="{{mix('resources/js/functions.js')}}"></script>
</head>
</div>
<body class=" overflow-hidden h-screen w-screen relative">
<div class=" grid w-full h-full grid-cols-[200px_minmax(900px,_1fr)] grid-rows-[1fr_minmax(1.75rem,20px)]">
    <aside id="sidebar" class="flex-shrink bg-slate-400 p-5">
        <div class="flex-shrink bg-slate-300 p-3">
            @if (Auth::check())
                <p class="text-xl">{{auth()->user()->first}} {{auth()->user()->last}}</p>
                <p class="text-m"><a href="/">Logout</a></p>
            @else
                <a href="/">Return to My Reporter</a>
            @endif
        </div>
        <nav>
            <ul id="dashboard" class="text-sm" role="list">
                <li><a class="bg-slate-200 p-2 py-3 my-2" href="/console/scripts/list">Scripts</a></li>
                <li><a class="bg-slate-200 p-2 py-3 my-2" href="/console/segmentTypes/list">Segment Types</a></li>
                <li><a class="bg-slate-200 p-2 py-3 my-2" href="/console/users/list">Users</a></li>
                <li><a class="bg-slate-200 p-2 py-3 my-2" href="/console/logout">Log Out</a></li>
            </ul>
        </nav>
    </aside>



    <main class="flex-grow overflow-y-auto h-full p-5">
{{--        <header class="w3-padding--}}
{{--        flex-shrink">--}}

{{--        <h1 class="text-3xl font-bold underline">--}}
{{--            Hello world!--}}
{{--        </h1>--}}

{{--        @if (Auth::check())--}}
{{--            You are logged in as {{auth()->user()->first}} {{auth()->user()->last}} |--}}
{{--            <a href="/console/logout">Log Out</a> |--}}
{{--            <a href="/console/dashboard">Dashboard</a> |--}}
{{--            <!-- <a href="/">Website Home Page</a> -->--}}
{{--        @else--}}
{{--            <a href="/">Return to My Reporter</a>--}}
{{--        @endif--}}

{{--        </header>--}}

{{--        <hr>--}}



        @yield ('content')

    </main>



    <div class="bg-slate-500 px-2 w-screen">
        <p class="text-white text-center">
        @if (session()->has('message'))
        {{session()->get('message')}}
        @endif
        </p>
    </div>
</div>





</body>
</html>