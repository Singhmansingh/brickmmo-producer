@extends('layout.console')

@section('breadcrumb')
    @include ('bootstrap.breadcrumb',['routes'=>array(
        array("name"=>"Music","link"=>"/console/music")
    )])
@endsection

@section('header')
    <h1>Music Tracks</h1>
@endsection

@section('content')
    <div class="relative overflow-x-auto container mx-auto">
        <div class="flex items-center justify-between py-4 bg-white dark:bg-gray-800">
            <div>
                <a href="/console/music/new" id="dropdownActionButton" data-dropdown-toggle="dropdownAction" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                    <span class="sr-only">Action button</span>
                    Upload Music
                </a>

            </div>

        </div>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Artist
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
            </thead>
            <tbody>
            @forelse($tracks as $track)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                    <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                        <i class="rounded-full fa-solid fa-music px-4"></i>
                        <div class="pl-3">
                            <div class="text-base font-semibold">{{$track->music_name}}</div>
                        </div>
                    </th>
                    <td class="px-6 py-4">
                        {{$track->music_artist}}
                    </td>

                    <td class="px-6 py-4">
                        <!-- Modal toggle -->
                        <a href="#" type="button"
                           data-modal-target="editTrackModal"
                           data-modal-show="editTrackModal"
                           data-track-name="{{$track->music_name}}"
                           data-track-artist="{{$track->music_artist}}"
                           data-track-src="{{$track->music_src}}"
                           data-track-id="{{$track->id}}"
                            onclick="editTrack(this)"
                           class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit track</a>
                    </td>
                </tr>
            @empty
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-600">
                    <td  class="flex font-semibold items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white bg-gray-50">
                        No music found
                    </td>
                    <td class="bg-gray-50"></td>
                    <td class="bg-gray-50"></td>
                </tr>
            @endforelse

            </tbody>
        </table>
        <!-- Edit user modal -->
        <div id="editTrackModal" tabindex="-1" aria-hidden="true" class="h-full fixed top-0 left-0 right-0 z-50 bg-neutral-700/50	 items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="container relative w-full max-w-lg max-h-full">
                <!-- Modal content -->
                <form id="form" action="/console/music/update" method='post' class="relative bg-white rounded-lg shadow dark:bg-gray-700 " >
                    @csrf
                    <input type="hidden" name="id" id="track-id">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Edit track
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="editTrackModal">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-6 gap-6">

                            <div class="col-span-6">
                                <label for="first-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Track Title</label>
                                <input type="text" name="music_name" id="track-name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Bonnie" required="">
                            </div>
                            <div class="col-span-6">
                                <label for="last-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Artist</label>
                                <input type="text" name="music_artist" id="track-artist" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Green" required="">
                            </div>
                            <div class="col-span-6">
                                <p class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Preview</p>
                                <audio controls id="player" controlsList="nodownload">
                                    <source id="player-src" src="#">
                                </audio>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
                        <button type="button" onclick="deleteTrack()" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function editTrack(el){
            gid('track-name').value=el.dataset.trackName;
            gid('track-artist').value=el.dataset.trackArtist;
            gid('track-id').value=el.dataset.trackId;
            gid('player-src').src='/storage/' + el.dataset.trackSrc+'#t=60';
            gid('player').load();

            gid('player').onpause = function(){
                this.currentTime=60;
            }
        }

        function deleteTrack(){
            var id = gid('track-id').value;
            var title = gid('track-name').value;
            if(!confirm('Are you sure you want to delete "'+title+'"? This action is irreversible.')) return;

            gid('form').action='/console/music/delete/'+id;
            gid('form').submit();
        }
    </script>
@endsection
