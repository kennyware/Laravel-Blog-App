@extends('layouts.app')

@section('content')
    <h1>Create Post</h1>
    {!! Form::open(['action' => 'PostsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('title', 'Title', ['class' => 'form-control'])}}
            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}
        </div>
        <div class="form-group">
            {{Form::label('body', 'Body', ['class' => 'form-control'])}}
            {{Form::textarea('body', '', ['class' => 'form-control', 'placeholder' => 'body', 'id' => 'article-ckeditor'])}}
        </div>
        
        <div class="form-group">
            {!!Form::file('cover_image')!!}
        </div>
        
        <div class="form-group">
            {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
        </div>
        
    {!! Form::close() !!}
@endsection