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
    <div class="card mt-4">
        <div class="card-header fw-bolder">
            Comments
        </div>
    @if ($post->comments->isNotEmpty())
        @foreach ($post->comments as $comment)  
            <div class="card-body">
                <p class="card-text">{{ $comment->body }}
                     <span class="test text-muted"> {{ $comment->updated_at->diffForHumans() }}</span></p>
                     <p class="text-secondary">Posted by: {{$comment->user->name}}</p>
                     <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#Modal_{{ $comment->id }}">
                    Edit
                </button>
                <form action="{{ route('posts.deleteComment', $comment->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Confirm to delete this post')">Delete</button>
                </form>
            </div>

            {{-- Modal Comment --}}
            <div class="modal fade" id="Modal_{{ $comment->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Comment</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('posts.updateComment', $comment->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                            <textarea class="form-control" name="body" rows="4"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                <button type="submit" class="btn btn-primary">Save changes</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
    @else
        <h4>&nbspNo comments yet.</h4>
    @endif        
    <div class="card mt-5">
        <div class="card-body p-4">
            <div class="d-flex flex-start w-100">

                <div class="w-100">
                    <h5>Add a comment</h5>

                    <form action="{{ route('posts.addComment', $post->id) }}" method="POST">
                        @csrf
                        <div class="form-outline">
                            <textarea class="form-control" name="body" rows="4"></textarea>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <button type="submit" class="btn btn-success">
                                Send <i class="fas fa-long-arrow-alt-right ms-1"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection