@extends('layout.console')

@section('header')
    <h1>Your Account</h1>
@endsection

@section('content')
    <div class="flex container mx-auto gap-12">
        <div class="flex-shrink">
            <img class="rounded-full border-2  w-36 h-36 shadow-lg" src="/assets/profile.png" alt="Extra large avatar">
        </div>
        <div class="flex-1">
            <h2 class="text-2xl font-bold  dark:text-white">{{ucfirst(Auth()->user()->first)}} {{ucfirst(Auth()->user()->last)}}</h2>
            <p class="my-2 text-lg text-gray-500">{{ucfirst(Auth()->user()->role)}}</p>
            <form id="userForm" action="/console/user/update/{{Auth()->user()->id}}" method="post" novalidate class="grid mt-5 grid-cols-2 gap-4 gap-y-6">
                @csrf
                <div class="col-span-1">
                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First name</label>
                    <input type="text" name="first" id="first_name" value="{{Auth()->user()->first}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John" required>
                </div>
                <div class="col-span-1">
                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last name</label>
                    <input type="text" name="last" id="last_name" value="{{Auth()->user()->last}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Doe" required>
                </div>
                <div class="col-span-2">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                    <input type="email" id="email" name="email" value="{{Auth()->user()->email}}" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@flowbite.com" >
                    <p id="helper-text-explanation" class="  mt-2 text-sm text-gray-500 dark:text-gray-400  @error('email') text-red-500 @enderror">Only humbermail emails are allowed.</p>
                </div>
                <div class="col-span-2">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Reset Password</label>
                    <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="********">

                </div>
                <div class="col-span-1">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Update</button>
                </div>
            </form>
        </div>

    </div>
@endsection
