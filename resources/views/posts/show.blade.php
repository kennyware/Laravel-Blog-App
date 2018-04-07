@extends('layouts.app')

@section('content')

        <h1>{{$post->title}}</h1>
        <small>Created {{$post->created_at}} By {{$post->user->name}}</small>
        <img class="img-fluid" src="{{$post->cover_image}}">
        <p>{!!$post->body!!}</p>

    <hr>

    @if(!Auth::guest())
        @if(Auth::user()->id == $post->user_id)
            <a href="/posts/{{$post->id}}/edit" class="btn btn-light btn-outline-dark float-left">Edit</a>
            {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST'])!!}
                {!!Form::hidden('_method', 'DELETE')!!}
                {!!Form::submit('Delete',['class' => 'btn btn-danger float-right'])!!}
            {!!Form::close()!!}
        @endif
    @endif
@endsection