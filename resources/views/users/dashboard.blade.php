<x-layout>
    <h1 class="title">Hello {{ auth()->user()->username }}</h1>

    <div class="card b-4">
        <h2 class="font-bold mb-4 text-center">Create a new post</h2>


        @if(session('success'))
            <div class="mb-2">
                <x-flashmsg msg="{{ session('success') }}" bg="bg-green-500"/>
            </div>
        @elseif(session('delete'))
        <div class="mb-2">
            <x-flashmsg msg="{{ session('delete') }}" bg="bg-red-500"/>
        </div>
        @endif

        <form action="{{route('posts.store')}}" method="post"
        enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="title">Post Title</label>
                <input type="text" name="title" value="{{ old('title') }}" class="input @error('title') ring-red-500 @enderror">
                @error('title')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="body">Post Content</label>
                <textarea name="body" rows="5" class="input @error('body') ring-red-500 @enderror">{{ old('body') }}</textarea>
                @error('body')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="image">Cover photo</label>
                <input type="file" name="image" id="image">

                @error('image')
                        <p class="error">{{ $message }}</p>
                @enderror
            </div>
            <button class="btn">Create</button>
        </form>
    </div>

    <h2 class="font-bold mb-4">Your latest posts:</h2>
    <div class="grid grid-cols-2 gap-6">
        @foreach ($posts as $post)
            <x-postCard :post="$post">
                {{--update post--}}
                <a href="{{route('posts.edit',$post)}}" class="bg-green-500 text-white px-2 py-1 text-xs rounded-md">
                    Update
                </a>

                {{--Delete post--}}
                <form action="{{route('posts.destroy',$post)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-500 text-white px-2 py-1 text-xs rounded-md">
                        Delete
                    </button>
                </form>
            </x-postCard>
        @endforeach
    </div>

    <div>
        {{$posts->links()}}
    </div>
</x-layout>
`
