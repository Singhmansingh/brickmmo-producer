<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>My Reporter</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script type="module" src="{{mix('resources/js/app.js')}}"></script>
    <script src="{{mix('resources/js/functions.js')}}"></script>
</head>
@php
$sidebar=true;
@endphp
<body class=" overflow-hidden h-screen w-screen relative">
<div class=" grid w-full h-full {{$sidebar ?  'grid-cols-[250px_minmax(900px,_1fr)]' : 'grid-cols-none' }}  grid-rows-[1fr_minmax(1.5rem,20px)] bg-slate-100">
    <aside id="sidebar" class="flex flex-col shadow-lg z-10 justify-between flex-shrink bg-slate-200 p-5 {{ !$sidebar ? 'hidden' : '' }}">
        <div class="flex-shrink p-3">
            @if (Auth::check())
                <p class="text-xl">{{auth()->user()->first}} {{auth()->user()->last}}</p>
                <p class="text-m"><a href="/">Logout</a></p>
            @else
                <a href="/">Return to My Reporter</a>
            @endif
        </div>
        <nav class="flex-shrink">
            <ul id="dashboard" class="text-sm" role="list">
                @php
                    $routes=array(
                      ["fa-solid fa-scroll","scripts","/console/scripts/list"],
                      ["fa-solid fa-filter","segment types","/console/segmentTypes/list"],
                      ["fa-solid fa-folder","segments","/console/segments/list"],
                      ["fa-solid fa-user","users","/console/users/list"],
                    );

                    sort($routes);
                @endphp
                @foreach($routes as $route)
                    <li><a class="font-semibold my-6 text-slate-600 hover:text-slate-500" href="{{$route[2]}}"><i class="{{$route[0]}} text-lg m-2 mr-3"></i>{{$route[1]}}</a></li>
                @endforeach

            </ul>
        </nav>
    </aside>

    <div class="flex-grow overflow-y-auto h-full">

    <header class="text-3xl font-bold  py-6 px-5 bg-white text-slate-800 border-b-4 border-amber-400 mb-7">
        @yield('header')
    </header>
        @yield ('widgets')
    <main class="container p-5 rounded-md mb-5 shadow-lg mx-auto border-2  bg-white">
        @yield ('content')
    </main>
    </div>

    <div class="bg-slate-300 px-2 w-screen z-20">
        <p class="text-white text-center">
        @if (session()->has('message'))
        {{session()->get('message')}}
        @endif
        </p>
    </div>
</div>





</body>
</html>
