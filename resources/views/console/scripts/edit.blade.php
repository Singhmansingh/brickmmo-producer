@extends('layout.console')
@section('breadcrumb')
    @include ('bootstrap.breadcrumb',['routes'=>array(
        array("name"=>"Scripts","link"=>"/console/scripts/list"),
        array("name"=>$segment->title,"link"=>"/console/scripts/edit/".$script->id),
    )])
@endsection
@section('header')
    <h1>Edit Script</h1>
@endsection
@section('content')
<form id="form" name="scriptForm" method="post"
      action="/console/scripts/save/{{$script->id}}"
      novalidate>
    @csrf
    <input type="hidden" value="{{$segment->id}}" name="segment_id"/>
    <div id="prompt">
        <h2 class="text-xl my-2">Repoter Details ({{$segment->type_name}})</h2>
        <p class="my-6">Create the script for the AI to read based on the reporter's prompts.</p>

        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div class="col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Segment Title</label>
                <p type="text" id="{{$segment->title}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{$segment->title}}</p>
            </div>
            @foreach($segmentDataFields as $field)
                <div>
                    <label for="{{$field->field_name}}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $field->field_label }}</label>
                    <p type="text" id="{{$field->field_name}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">@if($field->value) {{$field->value}} @else - @endif</p>
                </div>

            @endforeach
        </div>
        <hr/>
        <br/>


    </div>

    <h2 class="text-xl">Prompter</h2>
    <div >
        <label class=" my-4 block mb-2 text-sm font-medium text-gray-900 dark:text-white">AI Prompt</label>
        <textarea id="promptText" class="resize-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="script_prompt">{{$script->script_prompt}}</textarea>
        <button type="button" onclick="getScript()" class="my-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Generate Script <img id="loading" src="{{asset('assets/spinner.svg')}}" alt="loading script" class="w-9 inline hidden"></button>
    </div>

    <hr class="my-4"/>
    <h2 class="text-xl">Hosts</h2>
    <div id="hosts" class="flex overflow-x-auto max-w-full gap-4 p-5">
        @forelse($hosts as $host)
            <div class="flex flex-shrink items-center space-x-2 shadow-lg py-2 min-w-fit px-3 bg-zinc-100 dark:bg-zinc-400 rounded-full">
                @php
                $url = "https://reporters.brickmmo.com/storage/".$host->profile_pic;
                @endphp
                @if(@getimagesize($url))
                    <img class="bg-white w-10 h-10 rounded-full" src="{{$url}}" alt="">
                @else
                    <img class="bg-white w-10 h-10 rounded-full" src="/assets/profile.png" alt="">
                @endif
                <div class="font-medium dark:text-white">
                    <div class="mr-5">{{$host->name}}</div>
                    @php
                        $limit=50;
                        $personality = strlen($host->personality) > $limit ? substr($host->personality,0,$limit)."..." : $host->personality;

                    @endphp
                    <div class="mr-5 text-sm text-gray-500 dark:text-gray-400">{{$personality}}</div>
                </div>
            </div>
        @empty
            <p>No hosts available</p>
        @endforelse

    </div>

    <hr class="my-4"/>

    <h2 class="text-xl my-4">AI Script</h2>
    <p>Verify the script format. Use the format:  <span class="font-mono bg-zinc-100 px-2 rounded-md">Host: this is my line</span>. Remove any other characters. Separate lines with a line in-between. </p>
    <div id="script">
        <textarea name="chat_script" id="chat_script_content" class="whitespace-pre-wrap h-60 break-words resize-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{$script->chat_script}}</textarea>
        <button type="button" onclick="getAudio()" class="my-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Generate Audio <img id="script-loading" src="{{asset('assets/spinner.svg')}}" alt="loading audio" class="w-9 inline hidden"></button>

    </div>


    <hr class="my-4"/>

    <h2 class="text-xl my-4">Recording</h2>
    <p>Review the audio recording.</p>
    <div id="recording">
        <audio controls id="player">
            <source src="/storage/audio/{{$script->id}}.mp3">

        </audio>
    </div>

    <hr class="my-4"/>
    <div class="my-4 flex justify-end">
        <a href="/console/scripts/in-progress" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Return</a>
        <button type="button" onclick="deleteScript()" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">Delete</button>

        <button type="button" onclick="saveDraft()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Save & Close</button>
        <button type="submit" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-600">Approve</button>
    </div>
</form>

<script>
    async function getScript(){
        gid('loading').classList.remove('hidden');
        let prompt = gid("promptText").value;
        var xhr = new XMLHttpRequest();

        xhr.open("POST","/console/scripts/generate",true);
        xhr.setRequestHeader("Content-Type","application/json");
        xhr.setRequestHeader("X-CSRF-TOKEN",'{{ csrf_token() }}');
        xhr.onreadystatechange = function(){
            if(xhr.readyState==4)
                if(xhr.status==200)
                    loadScript(xhr.response);
                else {
                    gid('loading').classList.add('hidden');
                    alert(xhr.statusText);
                }
        }
        xhr.send(JSON.stringify({prompt}));
    }

    function loadScript(data){
        let scriptObj=JSON.parse(data);
        console.log(scriptObj['script']);
        gid('chat_script_content').value = scriptObj['script'];
        gid('loading').classList.add('hidden');
    }

    function getAudio(){
        gid('script-loading').classList.remove('hidden');
        let script = gid("chat_script_content").value;
        var xhr = new XMLHttpRequest();

        xhr.open("POST","/console/scripts/audio/{{$script->id}}",true);
        xhr.setRequestHeader("Content-Type","application/json");
        xhr.setRequestHeader("X-CSRF-TOKEN",'{{ csrf_token() }}');
        xhr.onreadystatechange = function(){
            if(xhr.readyState===4)
                if(xhr.status===200)
                    loadAudio();
        }
        xhr.send(JSON.stringify({script}));
    }

    function loadAudio(){
        gid('player').oncanplay = function(){
            gid('script-loading').classList.add('hidden');
        }
        gid('player').load();

    }

    function deleteScript(){
        if(!confirm("By confirming this deletion, you approve the following to occur:\r\n- The segment will be returned to the pool\r\n- Any audio that is exclusive to this script will be permanently removed\r\n Are you sure you want to delete this script?")) return;

        gid('form').action = "/console/scripts/delete/{{$script->id}}";
        gid('form').submit();

    }

    function saveDraft(){
        gid('form').action = '/console/scripts/draft/{{$script->id}}';
        gid('form').submit();

    }


</script>

@endsection
