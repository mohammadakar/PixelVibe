<x-layout>


    <a href="{{route('dashboard')}}" class="block mn-2 text-xs text-blue-500">
        &larr; Go back to the dashboard
    </a>

    <div class="card">
        <h2 class='font-bold mb-4'>Update your post</h2>
        <form enctype="multipart/form-data" action="{{route('posts.update',$post)}}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="title">Post Title</label>
                <input type="text" name="title" value="{{ $post->title }}" class="input @error('title') ring-red-500 @enderror">
                @error('title')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="body">Post Content</label>
                <textarea name="body" rows="5" class="input @error('body') ring-red-500 @enderror">{{$post->body}}</textarea>
                @error('body')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            @if ($post->image)
                <div>
                    <label>Current cover photo</label>
                        <img class="h-80 w-auto" src="{{asset('storage/' . $post->image)}}" alt="">
                </div>
            @endif
            <div class="mb-4">
                <label for="image">Cover photo</label>
                <input type="file" name="image" id="image">

                @error('image')
                        <p class="error">{{ $message }}</p>
                @enderror
            </div>
            <button class="btn">Update</button>
        </form>
    </div>

</x-layout>
