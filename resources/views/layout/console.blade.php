<html>
<head>
    <title>BR Producer</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="/assets/logo.png">
    <script type="module" src="/resources/js/app.js"></script>
</head>
<body>
<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                    </svg>
                </button>
                <span class="flex ml-2 md:mr-24">
                    <img src="/assets/logo.png" class="h-8 mr-3" alt="BrickMMO Radio Logo" />

                    <span class="self-center text-xl font-semibold sm:text-xl whitespace-nowrap dark:text-white">BrickMMO Producer</span>
                </span>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex ml-3 flex-col items-end">
                    <span class="font-semibold">{{auth()->user()->first}} {{auth()->user()->last}}</span>
                    <a href="/console/logout" class="text-sm underline">Log Out</a>
                </div>
                <a href="/console/user" aria-label="account details"><img src="/assets/profile.png" class="w-12 drop-shadow-md hover:drop-shadow-lg " ></a>
            </div>
        </div>
    </div>
</nav>

<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            @php
                $routes=array(
                    array("icon"=>"fa-solid fa-pie-chart","name"=>"Dashboard","route"=>"/console/dashboard"),
                  array("icon"=>"fa-solid fa-scroll","name"=>"Scripts","route"=>"/console/scripts/list"),
                  // array("icon"=>"fa-solid fa-folder","name"=>"Segments","route"=>"/console/segments/list"),
                  array("icon"=>"fa-solid fa-music","name"=>"Music","route"=>"/console/music"),
                );

                if(strtolower(auth()->user()->role) == 'admin')
                {
                    array_push($routes,
                        array("icon"=>"fa-solid fa-filter","name"=>"Segment Types","route"=>"/console/segmentTypes/list"),
                        array("icon"=>"fa-solid fa-calendar","name"=>"Schedule","route"=>"/console/schedule"),

                    );
                }

            @endphp
            @foreach($routes as $route)
                <li>
                    <a href="{{$route['route']}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <div class="flex-shrink-0 w-6 h-6 flex justify-center items-center text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">
                            <i class="{{$route['icon']}}"></i>
                        </div>
                        <span class="flex-1 ml-3 whitespace-nowrap">{{$route['name']}}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</aside>
<div class="p-4 md:ml-64">

    <div class="p-4  mt-14">
        @yield('breadcrumb')
        <header class="text-3xl font-bold  py-6 px-5 bg-white text-slate-800 border-b-4 border-amber-400 mb-7">
            @yield('header')
        </header>
        @yield('widgets')
        @yield('content')

    </div>

    @yield('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script>
        function gid(id){ return document.getElementById(id); }
    </script>

</div>
</body>
</html>
