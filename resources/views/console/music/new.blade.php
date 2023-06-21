@extends('layout.console')

@section('breadcrumb')
    @include ('bootstrap.breadcrumb',['routes'=>array(
        array("name"=>"Music","link"=>"/console/music"),
        array("name"=>"New Music Track","link"=>"/console/music/new"),
    )])
@endsection

@section('header')
    <h1>New Music Track</h1>
@endsection

@section('content')
    <form action="/console/music/save" method="post" class="container mx-auto"  enctype="multipart/form-data">
        @csrf
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="user_avatar">Track</label>

            <input name="music_file" required class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="user_avatar_help" id="music_file" type="file">
            <div class=" mt-2 text-sm  dark:text-gray-300 text-gray-500
            @error('music_file') text-red-500 @enderror
            " id="user_avatar_help">Acceptable formats: .mp3 (Max. 2 mb)</div>

        </div>
        <div class="mb-6">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Track Title (optional)</label>
            <input name="music_name" type="text" id="music-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >
        </div>
        <div class="mb-6">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Track Artist (optional)</label>
            <input name="music_artist" type="text" id="music-artist" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </div>

        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
    </form>
@endsection
