@extends('layouts.app')

@section('content')
    <h1>Posts</h1>
    <div class="dropdown">
        <label>Sort:</label>
        <span class="dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{current($sortingtypes)}}
        </span>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
        @foreach($sortingtypes as $sortingtype)
            <span class="dropdown-item">{{next($sortingtypes)}}</span>
        @endforeach
        </div>
    </div>
    @if(count($posts) > 0)
        @foreach($posts as $post)
            <div class="jumbotron">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img class="img-fluid" src="/storage/cover_images/{{$post->cover_image}}">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3><a href="posts/{{$post->id}}">{{$post->title}}</a></h3>
                        <small>Created {{$post->created_at}} by {{$post->user->name}}</small> 
                    </div>
                </div>
            </div>
        @endforeach
        {{$posts->links()}}
    @else
        <p>No posts where found</p>
    @endif
@endsection