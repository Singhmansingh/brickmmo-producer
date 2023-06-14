@extends('layout.console')

@section('breadcrumb')
    @include ('bootstrap.breadcrumb',['routes'=>array(
        array("name"=>"Scripts","link"=>"/console/scripts/list"),
        array("name"=>"Segments","link"=>"/console/segments/list")
    )])
@endsection

@section('header')
<h1>Segments</h1>
<p class="text-base my-4">Select a segment to start generating a new script.</p>

@endsection
@section('content')

@include('bootstrap.table',[
    "data"=>$segments,
    "cols"=>array(
        "Date"=>"created_at",
        "Type"=>"type_name",
        "Title"=>"title",
        ":Generate_Script"=>":generate_script:",
    ),
    "buttons"=>array(
        "generate_script"=>"/console/scripts/newScript"
    ),
    "paginated"=>true
])

@endsection
