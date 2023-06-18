@extends('layout.scriptlist')

@section('scriptlist')
<div class="relative flex flex-col gap-4 mt-4   overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 min-w-[1000px]">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>

            <th scope="col" class="text-center">
                Audio
            </th>
            <th scope="col" class="px-6 py-3">
                Title
            </th>

            <th scope="col" class="px-6 py-3">
                Date
            </th>
            <th scope="col" class="px-6 py-3">
                Script Status
            </th>
            <th scope="col" class="px-6 py-3">

            </th>

        </tr>
        </thead>
        <tbody>

        @forelse ($scripts as $row)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="px-4 text-center">
                    @include('bootstrap.play',['source'=>$row->id.".mp3"])
{{--                    @if($row['script_audio_src'])--}}
{{--                        @php--}}
{{--                        $row['script_audio_src']='test.mp3';--}}
{{--                        @endphp--}}
{{--                    <button aria-label="play script audio" onclick="playaudio(this)" role="button" tabindex="0" class="text-2xl text-amber-500 fa-solid fa-play-circle" src="{{ $row->script_audio_src }}"></button>--}}
{{--                    @else--}}
{{--                        <button class="text-2xl text-gray-300 fa-solid fa-play-circle" src="{{ $row->script_audio_src }}" aria-label="no audio"></button>--}}
{{--                    @endif--}}
                </td>
                <td class="px-6 py-4 ">
                    {{ $row->segment->title }}
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{  date('M dS, Y', strtotime($row->created_at)) }}
                </td>

                <td class="px-6 py-4">
                    @switch($row->script_status)
                        @case(0)
                            <span class="bg-gray-100 text-gray-600 p-1 px-2 rounded-lg text-xs">
                                Not Started
                            </span>
                            @break
                        @case(1)
                            <span class="bg-green-100 text-green-600 p-1 px-2 rounded-lg text-xs">
                                Approved
                            </span>
                            @break
                        @case(2)
                            <span class="bg-yellow-100 text-yellow-600 p-1 px-2 rounded-lg text-xs">
                                In Progress
                            </span>
                            @break
                        @case(3)
                            <span class="bg-blue-100 text-blue-600 p-1 px-2 rounded-lg text-xs">
                                Awaiting Approval
                            </span>
                            @break
                        @default

                    @endswitch
                </td>
                <td class="px-6 py-4">
                    <a class="text-blue-500 bg-white border-2 border-current hover:text-white hover:bg-blue-700 font-bold py-2 px-4 rounded-md" href="/console/scripts/edit/{{$row->id}}">Edit Script</a>
                </td>

            </tr>
            @empty
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th colspan="4" scope="row" class="px-6 py-4 font-medium text-center bg-gray-50 text-gray-900 whitespace-nowrap dark:text-white">
                        No Items Found
                    </th>
                </tr>
        @endforelse

        </tbody>
    </table>

</div>
<div class="mt-3">
    {{ $scripts->links() }}
</div>
{{--<audio id="player">--}}
{{--    <source id="source" src="/storage/audio/test.mp3">--}}
{{--</audio>--}}
{{--<script>--}}
{{--    function playaudio(element){--}}
{{--        let play="fa-play-circle";--}}
{{--        let playing="fa-pause";--}}
{{--        let player=document.getElementById('player')--}}

{{--        document.getElementById('source').src="storage/audio/"+element.src;--}}

{{--        player.play();--}}
{{--        element.classList.remove(play);--}}
{{--        element.classList.add(playing);--}}

{{--        element.onclick= function() {--}}
{{--            player.pause();--}}
{{--            element.classList.remove(playing);--}}
{{--            element.classList.add(play);--}}
{{--            element.onclick=()=>playaudio(element);--}}
{{--        }--}}

{{--        player.onended = function(){--}}
{{--            element.classList.remove(playing);--}}
{{--            element.classList.add(play);--}}
{{--            element.onclick= () => playaudio(element);--}}
{{--        }--}}
{{--    }--}}
{{--</script>--}}

@endsection
