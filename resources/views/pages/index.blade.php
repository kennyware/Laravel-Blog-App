@extends('layouts.app')

@section('content')
        <div class="jumbotron text-center">
                <h1>{{$title}}</h1>
                <p>Welcome to my very first project made in Laravel</p>
                <p><a class="btn btn-primary btn-lg" href="/login" role="button">Login</a><a class="btn btn-success btn-lg" href="/register" role="button">Signup</a></p>
        </div>
@endsection
