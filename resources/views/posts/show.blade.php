@extends('layouts.app')

@section('title') Show @endsection

@section('content')
    <div class="card mt-4">
        <div class="card-header">
            Post Info
        </div>
        <div class="card-body">
            <h5 class="card-title">Title: {{$post->title}}</h5>
            <p class="card-text">Description: {{$post->description}}</p>
            <p class="card-text">Created_at: {{\Carbon\Carbon::parse($post->created_at)->format('l, F j, Y') }}</p>

        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            Post Creator Info
        </div>
        <div class="card-body">
            <h5 class="card-title">Creator Name: {{ $user->name }}</h5>
            <p class="card-text">Creator Email: {{ $user->email }}.</p>
        </div>
    </div>

@endsection