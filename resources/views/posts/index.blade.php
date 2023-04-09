@extends('layouts.app')

@section('title') Index @endsection

@section('content')

    <div class="text-center">
    <a href="{{route('posts.create')}}"> <button type="button" class="mt-4 btn btn-success">Create Post</button></a>
    </div>
    <table class="table mt-4">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Slug</th>
            <th scope="col">Posted By</th>
            <th scope="col">Created At</th>
            <th scope="col">Actions</th>
            <th scope="col">Delete</th>

        </tr>
        </thead>
        <tbody>

        @foreach ($posts as $post)
            <tr>
            <td>{{ $post->id }}</td>
            <td>{{ $post->title }}</td>
            <td>{{ $post->slug }}</td>

                @if($post->user)
                    <td>{{$post->user->name}}</td>
                @else
                    <td>Not Found</td>
                @endif
                <td>{{$post->created_at}}</td>
                <td>
                    <a href="{{route('posts.show',$post['id'])}}" class="btn btn-info">View</a>
                    <a href="{{route('posts.edit',$post['id'])}}" class="btn btn-primary">Edit</a>
                </td>
                <td>
                    <form method="POST" action="{{ route('posts.destroy', $post->id) }}">
                        @csrf
                        @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Confirm to delete this post')">Delete</button>
                    </form>
                </td>
            </tr>

        @endforeach

        </tbody>
    </table>
    <div class="d-flex justify-content-center my-3">

    {{ $posts->links() }}

    </div>

@endsection
