@extends ('layout.console')

@section('breadcrumb')
    @include ('bootstrap.breadcrumb',['routes'=>array()])
@endsection

@section('header')
    <h1>Welcome to Brickmmo Producer!</h1>
@endsection

@section ('content')

<section>
    @if($isLive)

    <div class=" flex items-center justify-between bg-gradient-to-r from-green-500 to-green-400 flex-1  block  p-4 px-5 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
        <p class="  flex-shrink inline text-xl font-bold text-white tracking-tight text-center text-gray-900 dark:text-white"><i class="fa-solid fa-check-circle mr-3"></i> Radio is Live!</p>
        <audio controls class="flex-shrink">
            <source src="{{ getenv('RADIO_HOST')  }}/radio.mp3">
        </audio>
    </div>
    @else
        <div class=" bg-gradient-to-r from-gray-300 to-gray-200 flex-1  block  p-4 px-5 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <p class="  inline text-xl font-bold text-slate-500 tracking-tight text-center text-gray-900 dark:text-white"><i class="fa-solid fa-circle-arrow-down mr-3"></i>Radio is Offline</p>

        </div>
    @endif

    <div class="flex items-center justify-evenly my-6 gap-5">
        <div class="flex-1 block  p-4 border-double border-4 border-amber-500 bg-white text-amber-500 rounded-md shadow dark:bg-gray-800 dark:border-gray-700">
            <p class="text-xl font-bold tracking-tight text-center dark:text-white">{{ $listenerCount }} Current Listeners</p>
        </div>
        <div class="flex-1 block  p-4 border-double border-4 border-amber-500 bg-white text-amber-500 rounded-md shadow dark:bg-gray-800 dark:border-gray-700">
            <p class="text-xl font-bold tracking-tight text-center dark:text-white">{{ $segmentCount }} Inbound segments</p>
        </div>
        <div class="flex-1 block  p-4 border-double border-4 border-amber-500 bg-white text-amber-500 rounded-md shadow dark:bg-gray-800 dark:border-gray-700">
            <p class="text-xl font-bold tracking-tight  text-center dark:text-white">{{ $scriptCount }} Scripts in progress</p>
        </div>
    </div>

    <div class="relative">
        <hr>
        <h2 class="text-2xl font-bold text-slate-700 my-6">New Segments</h2>
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
                        Action
                    </th>

                </tr>
            </thead>
            <tbody>
                @foreach ($segments as $segment)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{date('M dS, Y', strtotime($segment->created_at)) }}
                    </th>
                    <td class="px-6 py-4">
                        {{ $segment->title }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $segment->type_name }}
                    </td>
                    <td class="px-6 py-4">
                        <a class="text-blue-500 bg-white border-2 border-current hover:text-white hover:bg-blue-700 font-bold py-2 px-4 rounded-md" href="/console/scripts/newScript/{{$segment->id}}">Generate Script</a>
                    </td>
                </tr>
                @endforeach



            </tbody>
        </table>
        {{$segments->links()}}
    </div>

</section>

@endsection
