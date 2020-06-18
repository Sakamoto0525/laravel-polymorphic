<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use DB;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return response()->json($posts, 200);
    }

    public function show($id)
    {
        // DB::enableQueryLog();

        $post = Post::with('tags')->find($id);
        // $post = Post::find($id)->tags->first()->pivot;

        // dd(DB::getQueryLog());

        if ($post === null) {
            return response()->json('not found', 404);
        }

        return response()->json($post, 200);
    }

    public function store(Request $request)
    {
        // Post::find(->tags()->sync($request->taggables);
        $post = Post::find($request->id);

        return response()->json(Post::with('tags')->find($request->id), 201);
    }

    /**
     * syncメソッドを使用して中間テーブルを保存する
     * params
     *  id        PostのID
     *  taggables Taggableの配列
     */
    public function store_sync(Request $request)
    {
        Post::find($request->id)->tags()->sync($request->taggables);

        return response()->json(Post::with('tags')->find($request->id), 201);
    }
}
