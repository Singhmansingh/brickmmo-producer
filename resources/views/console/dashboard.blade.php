@extends ('layout.console')

@section ('content')

<section class="container mx-auto">

    <div class="flex items-center justify-evenly my-10 gap-20">
        <div class="flex-1 block  p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <p class="mb-2 text-3xl font-bold tracking-tight text-center text-gray-900 dark:text-white">{{ $segmentCount }}</p>
            <h3 class="mb-2 text-xl font-bold tracking-tight text-center text-gray-900 dark:text-white">New Segments</h3>
        </div>
        <div class="flex-1 block  p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <p class="mb-2 text-3xl font-bold tracking-tight text-center text-gray-900 dark:text-white">{{ $needsApproval }}</p>
            <h3 class="mb-2 text-xl font-bold tracking-tight text-center text-gray-900 dark:text-white">Scripts need Approval</h3>
        </div>
    </div>

    <div class="relative">
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
                        Segment Type
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach ($segments as $segment)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $segment->created_at }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $segment->title }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $segment->type_name }}
                    </td>
                    <td class="px-6 py-4">
                        @if($segment->status==0)
                            <span class="bg-red-100 text-red-600 p-1 px-2 rounded-lg text-xs">
                                No Script
                            </span>
                        @else
                            <span class="bg-yellow-100 text-yellow-600 p-1 px-2 rounded-lg text-xs">
                                In Progress
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
                   
            </tbody>
        </table>
    </div>
    
</section>

@endsection
