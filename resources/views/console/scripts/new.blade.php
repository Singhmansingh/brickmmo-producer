@extends('layout.console')
@section('breadcrumb')
    @include ('bootstrap.breadcrumb',['routes'=>array(
        array("name"=>"Scripts","link"=>"/console/scripts/list"),
        array("name"=>$segment->title,"link"=>"/console/scripts/edit/".$script->id),
    )])
@endsection
@section('header')
<h1>New Script</h1>
<p class="mt-4 text-base font-normal">Create the script for the AI to read based on the reporter's prompts.</p>
@endsection
@section('content')
    <div id="modal" class="absolute w-screen h-screen bg-gray-800/25 top-0 left-0 flex items-center justify-center hidden">
        <div class="mw-30 bg-white rounded-lg drop-shadow-md flex flex-col overflow-hidden	">
            <div class="bg-sky-500 text-white text-3xl font-bold flex-shrink p-3">Loading</div>
            <div class="flex-grow p-4 mh-5">Generating Text-to-Speech...</div>
        </div>
    </div>
    <form name="scriptForm" onsubmit="openModal();" method="post" action="/console/scripts/save/{{$script->id}}" novalidate>
        @csrf
        <input type="hidden" value="{{$segment->id}}" name="segment_id"/>
        <div id="prompt">
            <h2 class="text-xl my-2">Reporter Details</h2>
            <p class="my-6">Create the script for the AI to read based on the reporter's prompts.</p>

            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div class="col-span-2">
                    <label for="segment_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Segment Name</label>
                    <p type="text" id="segment_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{$segment->title}}</p>
                </div>
                @foreach($segmentDataFields as $field)
                    <div>
                        <label for="{{$field->field_name}}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $field->field_label }}</label>
                        <p type="text" id="{{$field->field_name}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{$field->value}}</p>
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
        <h2 class="text-xl my-4">AI Script</h2>
        <p>Verify the script format. use the format <span class="code">Host: this is my line</span></p>
        <div id="script">
            <textarea name="chat_script" id="chat_script_content" id="scriptText" class="whitespace-pre-wrap h-60 break-words resize-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{$script->chat_script}}</textarea>
        </div>

        <hr class="my-4"/>

        <h2 class="text-xl my-4">Recording</h2>
        <p>Review the audio recording.</p>
        <div id="recording">
            <audio controls>
                <source src="/storage/audio/{{$script->id}}.mp3">
            </audio>
        </div>
        <hr class="my-4"/>
        <div class="my-4 flex justify-end">
            <button type="button" onclick="saveDraft()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Save Draft</button>
            <button type="submit" class="text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:ring-green-700 font-medium rounded-lg text-sm px-5 py-2.5 mr-2  dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">Approve</button>
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
            document.getElementById('chat_script_content').value = scriptObj['script'];
            document.getElementById('loading').classList.add('hidden');
        }

        function loadAudio(){

        }

        function saveDraft(){
            var xhr = new XMLHttpRequest();
            var prompt = document.forms.scriptForm.elements['script_prompt'].value;
            var script = document.forms.scriptForm.elements['chat_script'].value;

            console.log(prompt,script);

            xhr.open("POST","/console/scripts/draft/{{$script->id}}",true);
            xhr.setRequestHeader("Content-Type","application/json");
            xhr.setRequestHeader("X-CSRF-TOKEN",'{{ csrf_token() }}');
            xhr.onreadystatechange = function(){
                if(xhr.readyState==4)
                    if(xhr.status==200)
                        window.location.reload();
            }


            xhr.send(JSON.stringify({script_prompt: prompt, chat_script: script}));
        }

        function openModal(){
            document.getElementById('modal').classList.remove('hidden');
        }


    </script>

@endsection
