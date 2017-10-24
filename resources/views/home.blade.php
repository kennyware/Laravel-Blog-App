@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <h1 class="panel-heading">Dashboard</h1>

                <div class="panel-body my-5">
                <div class="my-5">
                    <span style="font-size: 28px;"> Your Blog Posts</span>
                    <a href="/posts/create" class="btn btn-primary float-right">Create Post</a>
                </div>    

                    @if(count($posts) < 1)
                        <p>You have no posts</p>
                    @else
                    <table class="table table-bordered my-2">
                        <thead class="">
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Date Created</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            <tr>
                        </thead>
                        <tbody>   
                            @foreach($posts as $post)
                                <tr>
                                    <th scope="row"><a class="text-dark" href="posts/{{$post->id}}">{{$post->title}}</a></th>
                                    <td><small>{{$post->created_at}}</small></td>
                                    <td><a href="/posts/{{$post->id}}/edit" class="btn btn-light btn-sm">Edit</a></td>
                                    <td>{!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST'])!!}
                                            {!!Form::hidden('_method', 'DELETE')!!}
                                            {!!Form::submit('Delete',['class' => 'btn btn-danger btn-sm float-right'])!!}
                                        {!!Form::close()!!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                       
                    @endif
                </div>

                
            </div>
        </div>
    </div>
</div>
@endsection
