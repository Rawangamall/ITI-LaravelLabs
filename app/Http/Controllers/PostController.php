<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class PostController extends Controller
{
    //
    public function index()
    {
        Paginator::useBootstrapFive();
        $posts = Post::paginate(4);
        return view('posts.index',[
            'posts' => $posts,
        ]);
    }

    public function show($id)
    {
       $post=Post::find($id);
       $user=User::find($post->user_id);
       // dd($user);
        return view('posts.show')->with(compact('user', 'post'));
    }

    public function create()
    {
        $users = User::all();

        return view('posts.create',[
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

           Post::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'user_id' => $data['post_creator'],
           ]);
           return to_route('posts.index');
    }

    public function edit($id)
    {
        $users = User::all();
        $post=Post::find($id);
         return view('posts.edit')->with(compact('users', 'post'));
    }

    public function update(Request $request, $id)
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

}
