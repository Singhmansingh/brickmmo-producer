@extends('layout.console')
@section('breadcrumb')
    @include ('bootstrap.breadcrumb',['routes'=>array(
        array("name"=>"Segment Types","link"=>"/console/segmentTypes/list")
    )])
@endsection
@section('header')
<h1>Segment Types</h1>

@endsection

@section('content')
    <div class="flex justify-between flex-wrap-reverse gap-y-4">

        <div class="md:justify-self-end basis-1/2 flex md:flex-shrink flex-1 items-center gap-4 justify-between md:justify-end ">
            <button onclick="newSegment()" class="py-2 px-4  flex-shrink text-center rounded-md border-2  flex items-center bg-gradient-to-r from-blue-600 to-blue-700 font-bold text-white shadow-lg">
                <p class="drop-shadow-md"><i class="fa-solid fa-plus"></i> New Segment Type</p>
            </button>
        </div>

    </div>

    <div class="relative flex flex-col gap-4 mt-4">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Segment Type Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Segment Fields
                </th>
                <th scope="col" class="px-6 py-3"></th>
            </tr>
            </thead>
            <tbody>

    @foreach($segmentTypes as $segmentType)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $segmentType->type_name }}
                </th>
                <td class="px-6 py-4 text-gray-500 whitespace-nowrap dark:text-white">
                   @foreach($segmentType->segmentFields as $sf)
                       {{$sf->field_name}}@if(!$loop->last), @endif
                   @endforeach
                </td>
                <td class="px-6 py-4 text-right">
                    <a class="text-blue-500 bg-white border-2 border-current hover:text-white hover:bg-blue-700 font-bold py-2 px-4 rounded-md" href="/console/segmentTypes/edit/{{$segmentType->id}}">Edit Segment Type</a>
                </td>

            </tr>

    @endforeach

            </tbody>
        </table>
    </div>

@endsection

@section('scripts')
    <script>
        function newSegment(){
            let type_name = prompt('Enter the name of the new segment type');
            if(type_name){
                fetch('/console/segmentTypes/new',{
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body:JSON.stringify({
                        type_name
                    })
                }).then(res => res.json())
                    .then((data)=>{
                        if(data.id){
                            window.location.href="/console/segmentTypes/edit/"+data.id;
                        }

                    });
            }
        }
    </script>
@endsection
