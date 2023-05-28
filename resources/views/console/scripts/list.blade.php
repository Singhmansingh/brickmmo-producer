@extends('layout.console')

@section('content')
<h1 class="text-3xl font-semibold my-6">Scripts</h1>

<a href="/console/segments/list" class="w-fit my-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">New Script</a>

@include('bootstrap.table',[
    "data"=>$scripts,
    "cols"=>array(
        "Title"=>"title",
        "Date"=>"created_at",
        "Script Status"=>"#script_status#",
        ":Edit_Script"=>":edit_script:",
    ),
    "buttons"=>array(
        "edit_script"=>"/console/scripts/edit"
    ),
    "tags"=>array(
        "colors"=>array(
          "gray",
          "green",
          "yellow",
          "blue"
        ),
        "script_status"=>array(
            "Not Started",
            "Approved",
            "In Progress",
            "Requires Review"
        )
    ),
    "paginated"=>true
])

@endsection
