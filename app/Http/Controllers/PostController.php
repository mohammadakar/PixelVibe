<?php

namespace App\Http\Controllers;
use App\Mail\WelcomeMail;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
class PostController extends Controller implements HasMiddleware{


    public static function middleware():array{
        return [
            new Middleware(['auth', 'verified'], except: ['index', 'show']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts=Post::latest()->paginate(6);
        return view('posts.index',['posts'=>$posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{

    // Validate the request
    $request->validate([
        'title' => ['required', 'max:255'],
        'body' => ['required'],
        'image'=>['nullable','file','max:12000','mimes:png,jpg,webp']
    ]);

    //Store image if exist (pyional for user)
    $path=null;
    if($request->hasFile('image')){
        $path=Storage::disk('public')->put('posts_images',$request->image);//storage is a build in class like Auth and Gate its role is to store images
    }


    // Create a post
    $post=Auth::user()->posts()->create([
        'title'=>$request->title,
        'body'=>$request->body,
        'image'=>$path,
    ]);

    //send mail
    Mail::to(Auth::user())->send(new WelcomeMail(Auth::user(),$post));

    // Redirect with success message
    return back()->with('success', 'Post created successfully!');
}


    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show',['post'=>$post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        Gate::authorize('modify',$post);//authorize is a build in function to authorize user and modify is a function i have created in the PostPolicy class
        return view("posts.edit",['post'=>$post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('modify',$post);
        /// Validate the request
        $request->validate([
            'title' => ['required', 'max:255'],
            'body' => ['required'],
            'image'=>['nullable','file','max:12000','mimes:png,jpg,webp']
        ]);
        $path=$post->image ?? null;
        if($request->hasFile('image')){
            if($post->image){
                Storage::disk('public')->delete($post->image);
            }
            $path=Storage::disk('public')->put('posts_images',$request->image);
        }

        // update a post
        $post->update([
            'title'=>$request->title,
            'body'=>$request->body,
            'image'=>$path,
        ]);

        // Redirect with success message
        return redirect()->route('dashboard')->with('success', 'Post Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //authorize the action
        Gate::authorize('modify',$post);

        //delete post image
        if($post->image){
            Storage::disk('public')->delete($post->image);
        }

        //delete post
        $post->delete();

        //redirect
        return back()->with('delete','Your post deleted successfully!');
    }
}
