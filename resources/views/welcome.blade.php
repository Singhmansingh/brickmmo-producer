<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>BR Producer</title>
        @vite('resources/css/app.css')
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="icon" href="/assets/logo.svg">
    </head>
    <body class="antialiased">
    <section class="bg-center bg-no-repeat bg-zinc-100 bg-gray-700">
        @if (Route::has('login'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10 bg-white w-full flex justify-between">

                <span class="flex ml-2 md:mr-24 items-center">
                    <img src="/assets/logo.svg" class="h-8 mr-3" alt="BrickMMO Radio Logo" />
                    <span class="self-center text-xl font-semibold sm:text-xl whitespace-nowrap dark:text-white">BrickMMO Producer</span>
                </span>
                @auth
                    <a href="{{ url('/console/dashboard') }}" class="font-semibold text-white bg-amber-500 rounded p-2 px-3 text-gray-600 hover:bg-amber-600 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Go to Console</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                    @endif
                @endauth
            </div>
        @endif
        <div class="px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-56">
            <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-[#ff9400] md:text-5xl lg:text-6xl">Welcome to BrickMMO Radio Producer!</h1>
            <p class="mb-8 text-lg font-normal text-slate-600 lg:text-xl sm:px-16 lg:px-48">Manage segments, scripts, and audio for the BrickMMO Radio!</p>
            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4">
                <a href="/console/login" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-red-500 hover:bg-red-600 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                    Login
                    <svg aria-hidden="true" class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </a>

            </div>
        </div>
    </section>
    <section class="container mx-auto grid grid-cols-3 gap-4 my-12 justify-center">
        <div class="max-w-sm mx-auto bg-whitedark:bg-gray-800 dark:border-gray-700 ">

            <a href="https://reporters.brickmmo.com/">
                <img class="rounded-t-lg" src="assets/reporter.svg" alt="" />
            </a>
            <div class="p-5">
                <p>
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Looking to write segments? Become a Reporter!</h5>
                </p>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Generate content based on the lego city, for the hosts to read!</p>
                <a href="https://reporters.brickmmo.com/" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-500 rounded-lg hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-red-500 dark:focus:ring-red-600">
                    Visit <i class="fa-solid fa-arrow-up-right-from-square ml-3"></i>
                </a>
            </div>
        </div>
        <div class="max-w-sm mx-auto bg-white dark:bg-gray-800 dark:border-gray-700">
            <a href="https://radio.brickmmo.com/">
                <img class="rounded-t-lg" src="assets/radio.svg" alt="" />
            </a>
            <div class="p-5">
                <p>
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Listen to the Live radio broadcast 24/7!</h5>
                </p>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Tune in 24/7 to hear the best tunes from the city, and hang out with your favourite BrickMMO radio personalities!</p>
                <a href="https://radio.brickmmo.com/" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-500 rounded-lg hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-red-500 dark:focus:ring-red-600">
                    Visit <i class="fa-solid fa-arrow-up-right-from-square ml-3"></i>
                </a>
            </div>
        </div>
        <div class="max-w-sm mx-auto bg-white  dark:bg-gray-800 dark:border-gray-700">
            <a href="/console/login">
                <img class="rounded-t-lg" src="assets/producer.svg" alt=""  />
            </a>
            <div class="p-5">
                <p>
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Build the show and moderate content as a Producer!</h5>
                </p>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Create the story that is told on the radio! Approve segments, adjust scripts, and create memorable stories!</p>
                <a href="/console/login" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-500 rounded-lg hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-red-500 dark:focus:ring-red-600">
                    Login
                    <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </a>
            </div>
        </div>
    </section>
    </body>
</html>
