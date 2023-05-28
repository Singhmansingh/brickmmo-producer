@extends('layout.console')

@section('content')

<h1 class="text-3xl">New Script</h1>
<p class="my-4">Create the script for the AI to read based on the reporter's prompts.</p>
<form method="post" action="/console/scripts/add" novalidate>
    @csrf
    <input type="hidden" value="{{$segment->id}}" name="segment_id"/>
    <div id="prompt">
        <h2 class="text-2xl my-2">Repoter Details ({{$segmentType}})</h2>

        <div class="grid gap-6 mb-6 md:grid-cols-2">
            @foreach($segmentDataFields as $field)

                <div>
                    <label for="{{$field->field_name}}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $field->field_name }}</label>
                    <p type="text" id="{{$field->field_name}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{$field->value}}</p>
                </div>
            @endforeach
        </div>

        <hr/>
        <br/>
    </div>
    <h2 class="text-2xl">Prompter</h2>
    <div>
        <label class=" my-4 block mb-2 text-sm font-medium text-gray-900 dark:text-white">AI Prompt</label>
        <textarea id="promptText" class="resize-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="script_prompt"></textarea>
        <button type="button" onclick="getScript()" class="my-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Generate Script <img id="loading" src="{{asset('assets/spinner.svg')}}" alt="loading script" class="w-9 inline hidden"></button>
    </div>
    <h2 class="text-2xl my-4">AI Script</h2>
    <div id="script">
        <input type="hidden" name="chat_script" id="chat_script_content">
        <pre id="scriptText" class="whitespace-pre-wrap break-words resize-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        </pre>
    </div>
    <div id="recording">

    </div>
    <div class="my-4">
        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Save Draft</button>
        <button type="submit" class="text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:ring-green-700 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">Approve</button>
    </div>
</form>
<script>
    async function getScript(){
        document.getElementById('loading').classList.remove('hidden');
        let prompt = document.getElementById("promptText").value;
        var xhr = new XMLHttpRequest();

        xhr.open("POST","/console/scripts/generate",true);
        xhr.setRequestHeader("Content-Type","application/json");
        xhr.setRequestHeader("X-CSRF-TOKEN",'{{ csrf_token() }}');
        xhr.onreadystatechange = function(){
            if(xhr.readyState==4)
                if(xhr.status==200)
                    loadScript(xhr.response);
                else {
                    document.getElementById('loading').classList.add('hidden');
                    alert(xhr.statusText);
                }
        }
        xhr.send(JSON.stringify({prompt}));
    }

    function loadScript(data){
        let scriptObj=JSON.parse(data);
        console.log(scriptObj['script']);
        document.getElementById('scriptText').innerHTML=scriptObj['script'];
        document.getElementById('chat_script_content').value = scriptObj['script'];
        document.getElementById('loading').classList.add('hidden');
    }


</script>

@endsection
