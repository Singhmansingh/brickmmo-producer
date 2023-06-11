<nav class="flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <i class="w-6 text-gray-400 fa-solid fa-home"></i>
            <a href="/console/dashboard" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                Home
            </a>
        </li>
        @foreach($routes as $route)
            <li class="inline-flex items-center">
                    <i class="w-6 text-gray-400 fa-solid fa-caret-right"></i>
                <a href="{{$route['link']}}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    {{$route['name']}}
                </a>
            </li>
        @endforeach

    </ol>
</nav>
