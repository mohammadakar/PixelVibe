@props(['post','full'=>false])

<div class="card">

    <div>
        @if ($post->image)
            <img class="h-80 w-auto" src="{{asset('storage/' . $post->image)}}" alt="">
        @else
        <img class="h-80 w-auto" src="{{asset('storage/posts_images/default.jpg')}}" alt="">
        @endif
    </div>

    <h2 class="font-bold text-xl m-4">{{$post->title}}</h2>

    <div class="text-sm font-light m-4">
        <span>Posted {{$post->created_at->diffForHumans()}} by</span>
        <a href="{{route('posts.user',$post->user)}}" class="text-blue-500 font-medium">{{$post->user->username}}</a>
    </div>

    @if ($full)
    <div class="text-sm m-4">
        <p>{{($post->body)}}</p>
    </div>
    @else
    <div class="text-sm m-4">
        <p>{{Str::words($post->body,30)}}</p>
        <a href="{{route('posts.show',$post)}}" class="text-blue-500">Read more...</a>
    </div>
    @endif

    <div class="flex items-center mt-6 justify-end gap-4">
        {{$slot}}
    </div>

</div>
