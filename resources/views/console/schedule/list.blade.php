@extends('layout.console')
@section('breadcrumb')
    @include ('bootstrap.breadcrumb',['routes'=>array(
        array("name"=>"Schedule","link"=>"/console/schedule"),
    )])
@endsection
@section('header')
    <h1>Schedule</h1>
@endsection

@section('content')
    <div class="flex my-3">
        <a href="/console/schedule/refresh" class="py-2 px-4  flex-shrink text-center rounded-md border-2  flex items-center bg-gradient-to-r from-blue-600 to-blue-700 font-bold text-white shadow-lg">
            Refresh Approved Segments
        </a>
    </div>

    <div class="flex gap-6">
        <div class="flex-1">
            <h2 class="text-xl font-semibold mb-4">Segments</h2>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th></th>
                        <th>ID</th>
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
                            <button onclick="sendSegmentReq({{$scheduledsegment->script->id}})"><i class="rounded-full fa-solid fa-music px-4"></i></button>
                        </td>
                        <td>{{$scheduledsegment->id}}</td>
                        <th scope="row" class="px-6 py-4 font-medium flex items-center text-gray-900 whitespace-nowrap dark:text-white">

                            {{$scheduledsegment->script->segment->title}}
                        </th>
                        <td class="px-6 py-3">
                            {{$scheduledsegment->script->segment->segmentType->type_name }}
                        </td>
                        <td class="text-center">
                            @include('bootstrap.play', ["source"=>$scheduledsegment->script_id.'.mp3'])
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex-1">
            <h2 class="text-xl font-semibold mb-4">Music</h2>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3"s></th>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Artist
                        </th>

                    </tr>
                    </thead>
                    <tbody>
                    @forelse($tracks as $track)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td>
                                <button onclick="sendReq({{$track->id}})"><i class="rounded-full fa-solid fa-music px-4"></i></button>
                            </td>
                            <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                <div class="pl-3">
                                    <div class="text-base font-semibold">{{$track->music_name}}</div>
                                </div>
                            </th>
                            <td class="px-6 py-4">
                                {{$track->music_artist}}
                            </td>

                        </tr>
                    @empty
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                            <td  class="flex font-semibold items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white bg-gray-50">
                                No music found
                            </td>
                            <td class="bg-gray-50"></td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <script>
        function sendReq(id){
            if(!confirm("Are you sure you want to queue this track? It will be played after the current track.")) return;
            var xhr = new XMLHttpRequest();
            xhr.open("POST","/radio/request",true);
            xhr.setRequestHeader("Content-Type","application/json");
            xhr.setRequestHeader("X-CSRF-TOKEN",'{{ csrf_token() }}');
            xhr.onreadystatechange = function(){
                if(xhr.readyState==4)
                    if(xhr.status==200)
                        alert("Success! song added to queue")
            }
            xhr.send(JSON.stringify({music_id:id}));
        }
        function sendSegmentReq(id){
            if(!confirm("Are you sure you want to queue this segment? It will be played after the current track.")) return;
            var xhr = new XMLHttpRequest();
            xhr.open("POST","/radio/request/segment",true);
            xhr.setRequestHeader("Content-Type","application/json");
            xhr.setRequestHeader("X-CSRF-TOKEN",'{{ csrf_token() }}');
            xhr.onreadystatechange = function(){
                if(xhr.readyState==4)
                    if(xhr.status==200)
                        alert("Success! segment added to queue")
            }
            xhr.send(JSON.stringify({script_id:id}));
        }
    </script>
@endsection

