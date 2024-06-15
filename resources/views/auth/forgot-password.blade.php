<x-layout>
    <h1 class="title">Request a password reset email</h1>
    @if(session('status'))
    <div class="mb-2">
        <x-flashmsg msg="{{ session('status') }}" bg="bg-green-500"/>
    </div>
    @endif
    <div class="mx-auto max-w-screen-sm card">
        <form action="{{route('password.request')}}" method="post" x-data="formSubmit" @submit.prevent="submit">
            @csrf
            <div class="mb-4">
                <label for="email">Email</label>
                <input type="text" name="email" value="{{old('email')}}" class="input @error('email') ring-red-500 @enderror">
                @error('email')
                    <p class="error">{{$message}}</p>
                @enderror
            </div>
            <button x-ref="btn" type="submit" class="btn">Request</button>
        </form>
    </div>
</x-layout>
