<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private static int $PAGE_SIZE = 10;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Display the direct replies to a post
     */
    public function replies(int $post_id) {
        $replies = Post::find($post_id)->childPosts;

        return response()->json(json_encode($replies));
    }

    /**
     * Display the direct replies to a post, paged, 10 replies per page
     */
    public function repliesPaged(int $post_id, int $page) {
        $replies = Post::find($post_id)->childPosts()->offset($page * PostController::$PAGE_SIZE)->limit(PostController::$PAGE_SIZE)->get();

        return response()->json(json_encode($replies));
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
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
