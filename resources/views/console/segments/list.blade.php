@extends('layout.console')

@section('content')
<h1 class="text-3xl font-semibold">Segments</h1>
<p class="text-sm my-4">Select a segment to start generating a new script.</p>
@include('bootstrap.table',[
    "data"=>$segments,
    "cols"=>array(
        "Date"=>"created_at",
        "Type"=>"type_name",
        "Title"=>"title",
        ":Generate_Script"=>":generate_script:",
    ),
    "buttons"=>array(
        "generate_script"=>"/console/scripts/new"
    ),
    "paginated"=>true
])

@endsection
