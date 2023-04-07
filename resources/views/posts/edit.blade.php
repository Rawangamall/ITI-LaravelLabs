@extends('layouts.app')
@section('title') Edit @endsection

@section('content')
    <form action="{{ route('posts.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Title</label>

            <input  type="text" name="title" value="{{$post->title}}" class="form-control" >

        </div>
        <div class="mb-3">
            <label  class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="3">{{$post->description}}</textarea>
        </div>

        <div class="mb-3">
            <label  class="form-label">Post Creator</label>
            <select class="form-control" name="user_id">
            @foreach ($users as $user)
            <!-- add attr selected to the value = the old one  -->
            <option value="{{$user->id}}"{{ $post->user_id == $user->id ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
            @endforeach
            </select>
        </div>

       <button class="btn btn-success">Submit</button>
    </form>
@endsection