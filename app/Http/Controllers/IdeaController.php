<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return all ideas
        $ideas = Idea::all();

        return response()->json($ideas);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //show an idea
        $idea = Idea::find($id);

        return response()->json($idea, 200);
    }

    //display an ideas comments
    public function showComments($id)
    {
        // find idea and comments
        $idea = Idea::with('comments')->find($id);

        $comments = $idea->comments;

        return response()->json($idea, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idea $idea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Idea $idea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $idea = Idea::find($id);

        // Delete the idea from the database
        $idea->delete();
        return response()->json(['message' => 'Post has been removed'], 200);
    }
}
