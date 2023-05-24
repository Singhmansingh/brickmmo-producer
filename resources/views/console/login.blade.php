@extends ('layout.login')

@section ('content')

    <section class="text-right">
        <p></p>
        <form method="post" action="/console/login" novalidate class="grid grid-cols-2 mx-auto gap-y-2">

            @csrf

                <label for="email" class="mr-3">Email Address:</label>
                <input class="border-2 border-solid border-slate-400 rounded-md" type="email" name="email" id="email" value="@if(isset($user)) {{$user->email}} @else {{old('email')}} @endif" required>

                @if ($errors->first('email'))
                    <br>
                    <span class="w3-text-red">{{$errors->first('email')}}</span>
                @endif

                <label for="password" class="mr-3">Password:</label>
                <input class="border-2 border-solid border-slate-400 rounded-md" type="password" name="password" id="password" required>

                @if ($errors->first('password'))
                    <br>
                    <span class="w3-text-red">{{$errors->first('password')}}</span>
                @endif

            <button class="col-span-2 bg-amber-500 text-white p-2 rad rounded-lg" type="submit">Log In</button>

        </form>

    </section>

@endsection
