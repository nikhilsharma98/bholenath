@extends('layouts.app')

@section('content')
    
    <h1>posts</h1>          
        
            @if(count($posts) > 0)                                                                                   )
                @foreach($posts as $post)
                <div class="well">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <img style="width:100%" src="/storage/cover_images/{{$post->cover_image}}">
                        </div>
                        <div class  ="col-md-8 col-sm-8">
                                <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                                <small>written on{{$post->created_at}} by {{$post->user->name}}</small>
                        </div>
                    </div>z
                </div>
            @endforeach
                  
            @else
                <p style="font-size:40px; color:blue;">No posts found</p>
            @endif
@endsection 