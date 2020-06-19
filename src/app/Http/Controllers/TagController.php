<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use DB;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        foreach ($tags as $tag) {
          foreach ($tag->posts as $post) {}
        }

        return response()->json($tags, 200);
    }

    public function show($id)
    {
        // DB::enableQueryLog();

        $tag = Tags::with('posts')->find($id);

        // dd(DB::getQueryLog());

        if ($tag === null) {
            return response()->json('not found', 404);
        }

        return response()->json($tag, 200);
    }

    public function store(Request $request)
    {
        // 普通にnew → save
        $tag = new Tag();
        $tag->name = $request->name;
        $tag->save();

        return response()->json($tag, 201);
    }
}
