<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    //
    public function index()
    {
        return PostResource::collection(Post::all());
    }

    public function store(Request $request){
        if ($request->ajax()) {
            try {
                //Validation
                $this->validate($request, [
                    'title' => 'required|string|max:255',
                    'description' => 'required|string|max:255',
                    'content' => 'required|string',
                    'category' => 'required|integer',
                    'published' => 'required|boolean',
                    'tags' => 'required',
                ]);

                $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title);
                $slug = strtolower($slug);

                //Save
                $post = new Post;
                $post->user_id = 3;
                $post->title = $request->title;
                $post->slug = $slug;
                $post->description = $request->description;
                $post->content = $request->content;
                $post->category_id = $request->category;
                $post->published = $request->published;
                $post->save();

                $tags = explode(",", $request->tags);
                $post->tags()->attach($tags);

                return response()->json([
                    'Message' => 'Ok',
                    'Post' => new PostResource($post)
                ]);

            } catch (ValidationException $error) {
                return response()->json(
                    $error->validator->errors()
                );
            }
        }
    }

    public function show(Post $post){
        return new PostResource(Post::findOrFail($post->id));
    }

    public function update(Request $request, Post $post){
        if ($request->ajax()) {
            try {
                //Validation
                $this->validate($request, [
                    'title' => 'required|string|max:255',
                    'description' => 'required|string|max:255',
                    'content' => 'required|string',
                    'category' => 'required|integer',
                    'published' => 'required|boolean',
                    'tags' => 'required',
                ]);

                $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $request->title);
                $slug = strtolower($slug);

                //Update
                $post->user_id = 3;
                $post->title = $request->title;
                $post->slug = $slug;
                $post->description = $request->description;
                $post->content = $request->content;
                $post->category_id = $request->category;
                $post->published = $request->published;
                $post->save();

                $tags = explode(",", $request->tags);
                $post->tags()->sync($tags);

                return response()->json([
                    'Message' => 'Ok',
                    'Post' => new PostResource($post)
                ]);

            } catch (ValidationException $error) {
                return response()->json(
                    $error->validator->errors()
                );
            }
        }
    }

    public function destroy(Post $post){
        $post->delete();

        return response()->json([
            'Message' => 'Ok',
            'Post' => new PostResource($post)
        ]);
    }
}