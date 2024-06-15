<x-layout>
    <h1 class="title">Welcome back!</h1>
    @if(session('status'))
    <div class="mb-2">
        <x-flashmsg msg="{{ session('status') }}" bg="bg-green-500"/>
    </div>
    @endif
    <div class="mx-auto max-w-screen-sm card">
        <form action="{{route('login')}}" method="post">
            @csrf
            <div class="mb-4">
                <label for="email">Email</label>
                <input type="text" name="email" value="{{old('email')}}" class="input @error('email') ring-red-500 @enderror">
                @error('email')
                    <p class="error">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password">Password</label>
                <input type="password" name="password"  class="input @error('password') ring-red-500 @enderror">
                @error('password')
                <p class="error">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-4 flex justify-between items-center">
                <div class="mb-4">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember me</label>
                </div>
                <a class="text-blue-500" href="{{route('password.request')}}">Forgot your password?</a>
            </div>
            @error('failed')
                <p class="error">{{$message}}</p>
            @enderror
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</x-layout>
