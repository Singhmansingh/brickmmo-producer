@extends('layout.console')

@section('header')
    <h1>Schedule</h1>
@endsection

@section('content')
    <div class="flex my-3">
        <a href="/console/schedule/refresh" class="py-2 px-4  flex-shrink text-center rounded-md border-2  flex items-center bg-gradient-to-r from-blue-600 to-blue-700 font-bold text-white shadow-lg">
            Refresh Schedule
        </a>
    </div>

    <div class="flex gap-6">

        <div class="flex-1">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th></th>
                        <th scope="col" class="px-6 py-3">
                            Segment name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Segment type
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Audio
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($schedule as $scheduledsegment)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="text-right w-7 text-right">
                        @if($scheduledsegment->is_playing)
                                <i class="fa-solid fa-caret-right text-green-600 text-3xl"></i>
                        @endif
                        </td>

                        <th scope="row" class="px-6 py-4 font-medium flex items-center text-gray-900 whitespace-nowrap dark:text-white">

                            {{$scheduledsegment->script->segment->title}}
                        </th>
                        <td class="px-6 py-3">
                            {{$scheduledsegment->script->segment->segmentType->type_name }}
                        </td>
                        <td class="text-center">
                            <i class="fa-solid fa-play-circle text-amber-500 text-2xl"></i>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex-1">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Product name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Color
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Category
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Price
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Apple MacBook Pro 17"
                        </th>
                        <td class="px-6 py-4">
                            Silver
                        </td>
                        <td class="px-6 py-4">
                            Laptop
                        </td>
                        <td class="px-6 py-4">
                            $2999
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Microsoft Surface Pro
                        </th>
                        <td class="px-6 py-4">
                            White
                        </td>
                        <td class="px-6 py-4">
                            Laptop PC
                        </td>
                        <td class="px-6 py-4">
                            $1999
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                    <tr class="bg-white dark:bg-gray-800">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Magic Mouse 2
                        </th>
                        <td class="px-6 py-4">
                            Black
                        </td>
                        <td class="px-6 py-4">
                            Accessories
                        </td>
                        <td class="px-6 py-4">
                            $99
                        </td>
                        <td class="px-6 py-4">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
