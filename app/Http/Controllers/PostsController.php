<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{
            /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $posts =    Post::orderBY('title','asc')->get();
        return view('posts.index')->with('posts', $posts);
        
        // $title= 'Welcome to Lravel!';
        //return view('posts.index', compact('title'));
        // return view('posts.index')->with('posts', $posts);
         
    }

    public function about()
    {
        $title= ' About Us';
        //return view('posts.index', compact('title'));
        return view('about.index')->with('title', $title);
        
    }

    public function Services()
    {
        $data = array(
        $title => 'Services',
        'services' => ['Web Design', 'Programming', 'Seo']
        );
        //return view('services.index', compact('title'));
        return view('posts.index')->with('title', $title);
        
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
        $this->validate ($request,[
        'title' => 'required',
        'body' => 'required',
        'cover_image' => 'image|nullable|max:1999'
        ]); 

        //Handle file upload
        if($request->hasfile('cover_image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            //get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();   
            // file name to store
            $fileNameToStore= $filename.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }
        else
        {
            $fileNameToStore = 'noimage'.jpg;   
        }

        //create post
        $post = new post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        
        $post->cover_image = $fileNameToStore;  
        $post->save();

        return redirect('/posts')->with ('success', 'Post Updated');    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = post::find($id);
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
        $post = post::find($id);

        // check for correct user
        if(auth()->user()->id !==$post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Page');       
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
        $this->validate ($request,[
            'title' => 'required',
            'body' => 'required'
            ]); 
    
            //create post
            $post = post::find($id);
            $post->title = $request->input('title');
            $post->body = $request->input('body');
                   
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

        // check for correct user   
        if(auth()->user()->id !==$post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized Page');       
        }


        $post->delete(); 

        return redirect('/posts')->with('success', 'Post Removed');
    }
}
