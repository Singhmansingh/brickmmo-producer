@extends('layout.console')

@section('content')
<h1 class="text-3xl font-semibold">Segments</h1>



@foreach($segments as $segmentType=>$segmentSet)
<div class="relative flex flex-col gap-4 mt-4">
    <h2 id="{{$segmentType}}-segments"class="text-2xl">{{ $segmentType }} Segments</h2>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Date
                </th>
                <th scope="col" class="px-6 py-3">
                    Title
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">

                </th>


            </tr>
        </thead>
        <tbody>

            @foreach ($segmentSet as $segment)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $segment->created_at }}
                </th>
                <td class="px-6 py-4">
                    {{ $segment->title }}
                </td>
                <td class="px-6 py-4">
                    <a class="text-white bg-blue-500 hover:bg-blue-700 font-bold py-2 px-4 rounded-full" href="/console/scripts/new/{{$segment->id}}">Generate Script</a>
                </td>

            </tr>
            @endforeach

        </tbody>
    </table>
</div>
<?php
    $otherpages = array();
    foreach($segments as $segmentkey=>$set){
        if($segmentkey != $segmentType) $otherpages[$segmentkey]=$set->currentPage();
    }
?>

{{ $segmentSet->appends($otherpages)->links() }}

@endforeach

@endsection
