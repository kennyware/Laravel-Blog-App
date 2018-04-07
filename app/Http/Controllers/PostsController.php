<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use App\Post;

$s3 = Storage::disk('s3');

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$posts = Post::orderBy('created_at', 'desc')->get();
        $sortingTypes = ['name' => 'title', "newest" => 'created_at'];
        $sortingOrders = 'asc';
        $posts = Post::orderBy($sortingTypes['newest'], $sortingOrders)->paginate(5);
        return view('posts.index',['posts' => $posts, 'sortingtypes' => $sortingTypes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
            ]);

        // Handle File Upload
        if($request->hasFile('cover_image')){
            
            //Get Filename with extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();

            //Get Filename without extension
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            //Get file extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            
            //Upload file
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
            $s3->put($fileNameToStore, file_get_contents($request->file('cover_image')), 'public');
            $url = $s3->url($fileNameToStore);
        }
        else{
            $url = 'https://s3.us-east-2.amazonaws.com/techvoice-img/noimage.jpg';
        }

        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $url;
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Access');
        }
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
            ]);

         // Handle File Upload
         if($request->hasFile('cover_image')){
            
            //Get Filename with extension
            $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();

            //Get Filename without extension
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

            //Get file extension
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            
            //Upload file
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }
        else{
            $fileNameToStore = 'noimage.jpg';
        }

        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_image')){
            $post->cover_image = $fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Access');
        }

        if($post->cover_image !== 'noimage.jpg'){
            Storage::delete('public/cover_images/'.$post->cover_image);
        }
        $post->delete();

        return redirect('/posts')->with('success', 'Post Deleted');
    }
}
