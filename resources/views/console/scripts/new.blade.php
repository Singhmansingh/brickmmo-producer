@extends('layout.console')

@section('content')
<h1 class="text-3xl">New Script</h1>
<form>
    <div id="prompt">
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            @foreach($segmentFields as $field)
                @switch($field->field_data_type)
                    @case("text")
                        <div>
                            <label for="{{$field->field_name}}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $field->field_name }}</label>
                            <input type="text" id="{{$field->field_name}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{$field->field_name}}" required>
                        </div>
                        @break

                @endswitch
            @endforeach
        </div>
    </div>
    <div id="script">

    </div>
    <div id="recording">

    </div>
    <input type="submit" value="Approve">
</form>

@endsection