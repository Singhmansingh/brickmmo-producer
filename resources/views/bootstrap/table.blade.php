<div class="relative flex flex-col gap-4 mt-2">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 my-6">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
            @foreach($cols as $label=>$toss)
                <th scope="col" class="px-6 py-3">
                    {{explode(':',$label)[0]}}
                </th>
            @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($data as $k=>$row)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-600">
                @foreach($cols as $label=>$col)
                    @if(preg_match('/^\:\S+\:$/',$col))
                        {{-- If the value is a link --}}
                        <td class="px-6 py-4">
                            <a class="text-blue-500 bg-white border-2 border-current hover:text-white hover:bg-blue-700 font-bold py-2 px-4 rounded-md" href="{{$buttons[trim($col,':')]}}/{{$row->id}}">{{ltrim(preg_replace('/\_/',' ',$label),':')}}</a>
                        </td>
                    @elseif(preg_match('/^\#\S+\#$/',$col))
                        {{-- If the value is a tag --}}
                        @php
                            $key=trim($col,'#');
                            $value=$row->$key;
                            $tagvalue=$tags[$key][$value];
                            $color=$tags['colors'][$value];
                        @endphp
                        <td class="px-6 py-4">
                            <span class="bg-{{ $color }}-100 text-{{ $color }}-600 p-1 px-2 rounded-lg text-xs">
                                {{ $tagvalue }}
                            </span>
                        </td>
                    @else
                        {{-- If the value just a normal value --}}
                        <td class="px-6 py-4">
                            {{$row->$col}}
                        </td>
                    @endif

                @endforeach
            </tr>
            @empty
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th colspan="4" scope="row" class="px-6 py-4 font-medium text-center bg-gray-50 text-gray-900 whitespace-nowrap dark:text-white">
                    No Items Found
                </th>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($paginated)
        {{$data->links()}}
    @endif
</div>




{{--
<div class="relative flex flex-col gap-4 mt-4">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>

            <th scope="col" class="px-6 py-3">
                Title
            </th>
            <th scope="col" class="px-6 py-3">
                Date
            </th>
            <th scope="col" class="px-6 py-3">
                Script Status
            </th>
            <th scope="col" class="px-6 py-3">

            </th>


        </tr>
        </thead>
        <tbody>

        @foreach ($data as $row)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                <td class="px-6 py-4">
                    {{ $row->title }}
                </td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $row->created_at }}
                </td>

                <td class="px-6 py-4">
                    @switch($row->script_status)
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
                    <a class="text-blue-500 bg-white border-2 border-current hover:text-white hover:bg-blue-700 font-bold py-2 px-4 rounded-md" href="/console/scripts/edit/{{$row->id}}">Edit Script</a>
                </td>

            </tr>
        @endforeach

        </tbody>
    </table>
    {{ $scripts->links() }}
</div>
--}}
