<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    //
    public function index()
    {
        Paginator::useBootstrapFive();
         $posts = Post::paginate(6);
        return view('posts.index',[
            'posts' => $posts,
        ]);
    }

    public function show($id)
    {
      $post = Post::with('comments')->where('id', $id)->first();
       $user=User::find($post->user_id);
    return view('posts.show')->with(compact('user', 'post'));
    }

    public function create()
    {
        $users = User::all();
        return view('posts.create',[
            'users' => $users
        ]);
    }

    public function store(StorePostRequest $request)
    {

        $data = $request->all();
        if($request->hasFile('image')){
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $fileExtension = $file->getClientOriginalExtension();
            $storedFileName = Storage::disk('public')->putFileAs('images', $file, $fileName);    
              }
            dd($storedFileName);

            Post::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'user_id' => $data['post_creator']
           ]);

           return to_route('posts.index');
    }

    public function edit($id)
    {
        $users = User::all();
        $post=Post::find($id);
         return view('posts.edit')->with(compact('users', 'post'));
    }

    public function update(StorePostRequest $request, $id)
    {
        $post = Post::find($id);
        if ($post){
            $post->title = $request->title;
            $post->description = $request->description;
            $post->user_id = $request->user_id;

        }
        $post->save();
        return redirect()->route('posts.index');
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if ($post) {
            $post->delete();
        }
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');;    
    }


    //comments
    public function addComment($id, StoreCommentRequest $request)
    {
        $data = $request->all();
        $post = Post::find($id);
     
        $post->comments()->create([
            'body' => $data['body'],
        ]);
        return redirect()->back();
    }

    public function updateComment(StoreCommentRequest $request, $id)
    {
        $comment = Comment::find($id);
        if ($comment) {
            $comment->body = $request->body;
            
        }
        $comment->save();

        return redirect()->route('posts.show', $comment->commentable_id);
    }

    public function deleteComment($id)
    {
        $comment = Comment::find($id);
        if ($comment) {
            $comment->delete();
        }
        return redirect()->back();
    }
}
