@extends('layout.console')

@section('content')
<h1 class="text-3xl font-semibold">Scripts</h1>

<div class="relative flex flex-col gap-4 mt-4">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Date
                </th>
                <th scope="col" class="px-6 py-3">
                    Title
                </th>
                <th scope="col" class="px-6 py-3">
                    Script Status
                </th>
                <th scope="col" class="px-6 py-3">
                    
                </th>
               
                
            </tr>
        </thead>
        <tbody>

            @foreach ($scripts as $script)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $script->created_at }}
                </th>
                <td class="px-6 py-4">
                    {{ $script->title }}
                </td>
                <td class="px-6 py-4">
                    @switch($script->script_status)
                        @case(0)
                            <span class="bg-gray-100 text-gray-600 p-1 px-2 rounded-lg text-xs">
                                Not Started
                            </span>
                            @break
                        @case(1)
                            <span class="bg-green-100 text-green-600 p-1 px-2 rounded-lg text-xs">
                                Approved
                            </span>
                            @break
                        @case(2)
                            <span class="bg-yellow-100 text-yellow-600 p-1 px-2 rounded-lg text-xs">
                                In Progress
                            </span>
                            @break
                        @case(3)
                            <span class="bg-blue-100 text-blue-600 p-1 px-2 rounded-lg text-xs">
                                Awaiting Approval
                            </span>
                            @break
                        @default
                            
                    @endswitch
                </td>
                <td class="px-6 py-4">
                    <a class="text-white bg-blue-500 hover:bg-blue-700 font-bold py-2 px-4 rounded-full" href="#">Generate Script</a>
                </td>
                
            </tr>
            @endforeach
               
        </tbody>
    </table>
    {{ $scripts->links() }}
</div>
@endsection