<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Post\Post;
use File;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')
            ->except(['index', 'show']);
    }

    public function index()
    {
        $posts = Post::with(['user','category'])->orderBy('created_at', 'desc')->get();

        return response()
            ->json([
                'posts' => $posts
            ]);
    }

    public function create()
    {
        $form = Post::form();
        return response()
            ->json([
                'form' => $form
            ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'content' => 'required|max:3000',
            'tags' => 'required|max:255',
            'image' => 'image'
        ]);

        if(!$request->hasFile('image') && !$request->file('image')->isValid()) {
            return abort(404, 'Image not uploaded!');
        }

        $filename = $this->getFileName($request->image);
        $request->image->move(base_path('public/images'), $filename);

        $post = new Post($request->only('category_id', 'name', 'content', 'tags'));
        $post->image = $filename;

        $request->user()->posts()
            ->save($post);

        return response()
            ->json([
                'saved' => true,
                'id' => $post->id,
                'message' => 'You have successfully created post!'
            ]);
    }

    private function getFileName($file)
    {
        return str_random(32).'.'.$file->extension();
    }

    public function show($id)
    {
        $post = Post::with(['user','category'])
            ->findOrFail($id);

        return response()
            ->json([
                'post' => $post
            ]);
    }

    public function edit($id, Request $request)
    {
        $form = Post::with(['user','category'])
            ->findOrFail($id);

       return response()
            ->json([
                'form' => $form
            ]);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required|max:255',
            'content' => 'required|max:3000',
            'tags' => 'required|max:255',
            'image' => 'image'
        ]);

        $post = $request->user()->posts()
            ->findOrFail($id);

        $post->category_id = $request->category_id;
        $post->name = $request->name;
        $post->content = $request->content;
        $post->tags = $request->tags;

        // upload image
        if ($request->hasfile('image') && $request->file('image')->isValid()) {
            $filename = $this->getFileName($request->image);
            $request->image->move(base_path('/public/images'), $filename);

            // remove old image
            File::delete(base_path('/public/images/'.$post->image));
            $post->image = $filename;
        }

        $post->save();

        return response()
            ->json([
                'saved' => true,
                'id' => $post->id,
                'message' => 'You have successfully updated equipo!'
            ]);
    }

    public function destroy($id, Request $request)
    {
        $post = $request->user()->posts()
            ->findOrFail($id);

        // remove image
        File::delete(base_path('/public/images/'.$post->image));

        $post->delete();

        return response()
            ->json(['deleted' => true]);
    }
}
