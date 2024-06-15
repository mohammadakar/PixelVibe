<x-layout>
    <h1 class="title">Reset password</h1>
    <div class="mx-auto max-w-screen-sm card">
        <form action="{{route('password.update')}}" method="post" >
            @csrf

            <input type="hidden" name="token" value="{{$token}}">

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
            <div class="mb-8">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" class="input">
            </div>

            <button type="submit" class="btn">Reset Password</button>
        </form>
    </div>
</x-layout>
