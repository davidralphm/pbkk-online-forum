<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ReplyController extends Controller
{
    // Return reply edit view
    public function edit(int $id) {
        $reply = Reply::find($id);

        if (empty($reply)) {
            return back()->withErrors('Reply not found!');
        }

        return view('reply.edit', ['reply' => $reply]);
    }

    // Reply edit post
    public function editPost(Request $request, int $id) {
        $reply = Reply::find($id);

        if (empty($reply)) {
            return back()->withErrors('Reply not found!');
        }

        $validated = $request->validate(
            ['body' => 'required'],
            ['body' => 'Reply body is required']
        );

        $reply->body = $request->body;
        $reply->save();

        Session::flash('message-success', 'Reply edited successfully!');
        return redirect('/question/view/' . $reply->question_id);
    }

    // Delete reply function
    public function delete(Request $request, int $id) {
        $reply = Reply::find($id);

        if (empty($reply)) {
            return back()->withErrors('Reply not found!');
        }

        // Set deleted flag to true
        $reply->deleted = true;
        $reply->save();

        Session::flash('message-success', 'Reply deleted successfully!');
        return back();
    }
    
    // Upvote a reply function
    public function upvote(int $id) {
        $reply = Reply::find($id);

        if (empty($reply)) {
            return back()->withErrors('Reply not found!');
        }

        // Check if the user has already upvoted this reply
        $vote = $reply->userVote();

        if ($vote != null) {
            // If the user has already upvoted
            if ($vote->type == 'upvote') {
                return back()->withErrors('You have already upvoted this reply!');
            }

            // Else change the vote type to upvote
            $vote->type = 'upvote';
        } else {
            // If the user hasn't voted, create a new vote
            $vote = new Vote;

            $vote->user_id = Auth::id();
            $vote->reply_id = $reply->id;
        }

        // Create a new vote for this reply
        
        $vote->type = 'upvote';
        $vote->save();

        Session::flash('message-success', 'Reply upvoted successfully!');
        return back();
    }

    // Downvote a reply function
    public function downvote(int $id) {
        $reply = Reply::find($id);

        if (empty($reply)) {
            return back()->withErrors('Reply not found!');
        }

        // Check if the user has already downvoted this reply
        $vote = $reply->userVote();

        if ($vote != null) {
            // If the user has already downvoted
            if ($vote->type == 'downvote') {
                return back()->withErrors('You have already downvoted this reply!');
            }

            // Else change the vote type to downvote
            $vote->type = 'downvote';
        } else {
            // If the user hasn't voted, create a new vote
            $vote = new Vote;

            $vote->user_id = Auth::id();
            $vote->reply_id = $reply->id;
        }

        // Create a new vote for this reply
        
        $vote->type = 'downvote';
        $vote->save();

        Session::flash('message-success', 'Reply downvoted successfully!');
        return back();
    }

    // Unvote a reply function
    public function unvote(int $id) {
        $reply = Reply::find($id);

        if (empty($reply)) {
            return back()->withErrors('Reply not found!');
        }

        // Check if vote exists
        $vote = $reply->userVote();

        if ($vote == null) {
            return back()->withErrors('You have not voted on this reply');
        }

        $vote->delete();

        Session::flash('message-success', 'Reply unvoted!');
        return back();
    }
}
