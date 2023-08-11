<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Idea;

class LikesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($ideaid, $userid)
    {
        $likeExists = Likes::where('user_id', $userid)
                          ->where('idea_id', $ideaid)
                          ->first();

        if ($likeExists) {
            return response()->json(['error' => 'Like exists'], 400);
        }
        //$user = User::find($userid);
        //$post = Idea::find($ideaid);
        $like = new Likes();
        $like->user_id = $userid;
        $like->idea_id = $ideaid;
        $like->save();

        return response()->json(['message' => 'Idea liked.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Likes $likes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Likes $likes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Likes $likes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($ideaid, $userid)
    {
        $like = Likes::where('user_id', $userid)
            ->where('idea_id', $ideaid)
            ->first();

        $like->delete();
        return response()->json(['message' => 'Idea unliked'], 200);
    }
}
