<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;
use App\Models\User;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return all ideas
        //$ideas = Idea::withCount('comments')->get();
        //$ideas = Idea::with('user')->get();
        $ideas = Idea::with(['user:id,name', 'likes'])
                     ->withCount('comments', 'likes')
                     ->get();
                     

        return response()->json($ideas);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        // Create a new idea instance
        $idea = new Idea();
        $idea->title = request('title');
        $idea->content = request('content');
        $idea->user_id = request('user_id');
        $idea->save();

        return response()->json($idea, 201);
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
        // find idea and comments //with username
        $idea = Idea::with(['user:id,name', 'comments.user:id,name'])->find($id);

        $comments = $idea->comments;

        return response()->json($idea, 200);
    }
    //display certain users ideas
    public function getUserIdeas($id)
    {
        $user = User::find($id);
        $ideas = $user->ideas;

    return response()->json($ideas, 200);

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
    public function update($id)
    {
        $idea = Idea::find($id);
        $idea->title = request('title');
        $idea->content = request('content');

        $idea->save();

        return response()->json($idea, 200);
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
