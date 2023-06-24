@extends('layout.console')
@section('breadcrumb')
    @include ('bootstrap.breadcrumb',['routes'=>array(
        array("name"=>"Segment Types","link"=>"/console/segmentTypes/list"),
        array("name"=>"New Segment","link"=>"#"),
    )])
@endsection
@section('header')
<h1>Segment Types</h1>

@endsection
@section('content')

<?php
  $inputClass="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500";
  $fieldsetClass="w-full grid grid-cols-[repeat(3,minmax(0,_1fr))_150px] w-full gap-6 items-center";
  $remButtonClass="text-red-500 border-2 border-current text-sm hover:bg-red-500 hover:border-red-500 hover:text-white font-semibold py-1 px-2 rounded";
  $buttonClass="text-white bg-blue-500 hover:bg-blue-600 font-bold py-2 px-4 rounded hover:cursor-pointer";
?>


<form id="fieldForm" method="post" action="/console/segmentTypes/edit/{{$segmentType->id}}" class="w-full grid grid-flow-row gap-6 mt-6 grid-rows-auto">
    @csrf
    <input type="hidden" value="{{$segmentType->id}}" name="segment_type_id">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl flex-shrink">Edit Segment Type {{ucwords($segmentType->type_name)}}</h2>
        <input class="{{$buttonClass}} flex-shrink w-1/6 bg-green-600 hover:bg-green-700" type="submit" value="Save">

    </div>
    <div id="fields" class="grid grid-flow-row  gap-6">

    @foreach($fields as $x=>$field)
        <fieldset id="{{$x}}_fieldset" class="{{$fieldsetClass}}">
            <div class="flex flex-col gap-2">
                <label class="text-sm">Label</label>
                <input name="fieldLabels[]" type="text" value="{{ $field->field_label }}" class="{{$inputClass}}">
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-sm">Input Name</label>
                <input name="fieldNames[]" type="text" value="{{ $field->field_name }}" class="{{$inputClass}}">
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-sm">Data Type</label>
                <input name="fieldTypes[]" type="text" value="{{ $field->field_data_type }}" class="{{$inputClass}}">
            </div>
            <div class="flex flex-col h-full justify-end">
                <button type="button" onclick="removeField('{{$x}}_fieldset')" class="{{$remButtonClass}}">Remove</button>
            </div>
        </fieldset>
    @endforeach
    </div>

    <button type="button" onclick="newField()" class="{{$buttonClass}}">Add Field</button>

</form>

<script>
    function newField(){
        var index=gid("fields").children.length;
        gid("fields").innerHTML += `
        <fieldset id="${index}_fieldset" class="{{$fieldsetClass}}">
            <div class="flex flex-col gap-2">
                <label class="text-sm">Label</label>
                <input name="fieldLabels[]" type="text" class="{{$inputClass}}">
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-sm">Input Name</label>
                <input name="fieldNames[]" type="text" class="{{$inputClass}}">
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-sm">Data Type</label>
                <input name="fieldTypes[]" type="text" class="{{$inputClass}}">
            </div>
             <div class="flex flex-col h-full justify-end">
                <button type="button" onclick="removeField('${index}_fieldset')" class="{{$remButtonClass}}">Remove</button>
            </div>
        </fieldset>
        `
    }
    function removeField(id){
        // if(!confirm("Are you sure you want to remove this field?")) return;
        gid(id).remove();
    }
</script>
@endsection

