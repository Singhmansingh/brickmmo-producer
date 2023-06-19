@extends('layout.console')

@section('breadcrumb')
    @include ('bootstrap.breadcrumb',['routes'=>array(
        array("name"=>"Scripts","link"=>"/console/scripts/list")
    )])
@endsection

@section('header')
    <h1>Scripts</h1>
@endsection



@section('content')

<div class="flex justify-between flex-wrap-reverse gap-y-4">
    <div class="flex gap-3 justify-evenly md:justify-start sm:flex-1">
        <a class="<?php echo (Request::path() === 'console/scripts/list') ? 'bg-red-400 text-white' : 'bg-white text-red-400' ?>
    flex-shrink whitespace-nowrap rounded-sm shadow-md border-red-400 border-2 text-center items-center flex p-1 px-4 font-bold" href="/console/scripts/list">All</a>
        <a class="<?php echo (Request::path() === 'console/scripts/in-progress') ? 'bg-amber-400 text-white' : 'bg-white text-amber-400' ?>
    flex-shrink whitespace-nowrap rounded-sm shadow-md border-amber-400 border-2 text-center items-center flex p-1 px-4 font-bold" href="/console/scripts/in-progress">In Progress</a>
        <a class="<?php echo Request::path() === 'console/scripts/approved' ? 'bg-green-400 text-white' : 'bg-white text-green-400' ?>
    flex-shrink whitespace-nowrap rounded-sm shadow-md border-green-400 border-2 text-center items-center flex p-1 px-4 font-bold" href="/console/scripts/approved">Approved</a>
        <a class="<?php echo Request::path() === 'console/scripts/needs-approval' ? 'bg-blue-400 text-white' : 'bg-white text-blue-400' ?>
    flex-shrink whitespace-nowrap rounded-sm shadow-md border-blue-400 border-2 text-center items-center flex p-1 px-4 font-bold" href="/console/scripts/needs-approval">Awaiting Approval</a>
    </div>


    <div class="md:justify-self-end basis-1/2 flex md:flex-shrink flex-1 items-center gap-4 justify-between md:justify-end ">
        <p class="font-semibold flex-shrink text-slate-700">({{ $unusedsegments }}) Unused Segments</p>
        <a href="/console/segments/list" class="py-2 px-4  flex-shrink text-center rounded-md border-2  flex items-center bg-gradient-to-r from-blue-600 to-blue-700 font-bold text-white shadow-lg">
            <p class="drop-shadow-lg"><i class="fa-solid fa-plus"></i> New Script</p>
        </a>
    </div>

</div>
<hr class="my-2"/>
@yield('scriptlist')

@endsection
