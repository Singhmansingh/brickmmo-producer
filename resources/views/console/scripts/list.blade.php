@extends('layout.console')

@section('header')
    <h1>Scripts</h1>
@endsection
@section('content')
<div class="my-4">
    <a href="/console/segments/list" class="w-fit my-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">New Script</a>
</div>

<h2 class="text-2xl">Scripts Awaiting Approval</h2>

@include('bootstrap.table',[
    "data"=>$scriptsNeedApproval,
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

<h2 class="text-2xl">Scripts In Progress</h2>

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

<h2 class="text-2xl">Approved Scripts</h2>
@include('bootstrap.table',[
"data"=>$scriptsApproved,
"cols"=>array(
    "Title"=>"title",
    "Date"=>"approval_date",
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
