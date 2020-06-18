<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Taggable;
use DB;

class TaggableController extends Controller
{
    public function index()
    {
        $taggables = Taggable::all();

        return response()->json($taggables, 200);
    }

    public function show($id)
    {
        // DB::enableQueryLog();

        $taggable = Taggable::with('post')->find($id);

        // dd(DB::getQueryLog());

        if ($taggable === null) {
            return response()->json('not found', 404);
        }

        return response()->json($taggable, 200);
	}

	public function store(Request $request)
	{
		$taggable = new Taggable();

        $taggable->tag_id = $request->tag_id;
        $taggable->taggable_id = $request->taggable_id;
		$taggable->taggable_type = $request->taggable_type;
		$taggable->value = $request->value;

        \DB::beginTransaction();

        try {
			$taggable->save();

            \DB::commit();
        } catch (\Exception $e) {
			var_dump($e);
            //ログの出力
            \Log::Error($e->getTraceAsString());
			\DB::rollback();

            return response()->json('create error', 500);
        }

        return response()->json($taggable, 201);
	}
}
