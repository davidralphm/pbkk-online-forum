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
        $reply = Reply::findOrFail($id);

        // if (empty($reply)) {
        //     return back()->withErrors('Reply not found!');
        // }

        return view('reply.edit', ['reply' => $reply]);
    }

    // Reply edit post
    public function editPost(Request $request, int $id) {
        $reply = Reply::findOrFail($id);

        // if (empty($reply)) {
        //     return back()->withErrors('Reply not found!');
        // }

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
        $reply = Reply::findOrFail($id);

        // if (empty($reply)) {
        //     return back()->withErrors('Reply not found!');
        // }

        // Set deleted flag to true
        $reply->deleted = true;
        $reply->save();

        Session::flash('message-success', 'Reply deleted successfully!');
        return back();
    }
    
    // Upvote a reply function
    public function upvote(int $id) {
        $reply = Reply::findOrFail($id);

        // if (empty($reply)) {
        //     return back()->withErrors('Reply not found!');
        // }

        // Check if the user has already upvoted this reply
        $vote = $reply->userVote();
        $alreadyVoted = false;

        if ($vote != null) {
            // If the user has already upvoted
            if ($vote->type == 'upvote') {
                return back()->withErrors('You have already upvoted this reply!');
            }

            // Else change the vote type to upvote
            $vote->type = 'upvote';

            $alreadyVoted = true;
        } else {
            // If the user hasn't voted, create a new vote
            $vote = new Vote;

            $vote->user_id = Auth::id();
            $vote->reply_id = $reply->id;
        }

        // Create a new vote for this reply
        $vote->type = 'upvote';
        $vote->save();

        // Check if the upvoted reply is the question body of a question
        if ($reply->id === $reply->question->firstReply->id) {
            $question = $reply->question;

            // If already voted (meaning a down vote), add 2 to the number of upvotes, else 1
            if ($alreadyVoted) {
                $question->upvotes += 2;
            } else {
                $question->upvotes += 1;
            }

            $question->save();
        }

        Session::flash('message-success', 'Reply upvoted successfully!');
        return back();
    }

    // Downvote a reply function
    public function downvote(int $id) {
        $reply = Reply::findOrFail($id);

        // if (empty($reply)) {
        //     return back()->withErrors('Reply not found!');
        // }

        // Check if the user has already downvoted this reply
        $vote = $reply->userVote();
        $alreadyVoted = false;

        if ($vote != null) {
            // If the user has already downvoted
            if ($vote->type == 'downvote') {
                return back()->withErrors('You have already downvoted this reply!');
            }

            // Else change the vote type to downvote
            $vote->type = 'downvote';

            $alreadyVoted = true;
        } else {
            // If the user hasn't voted, create a new vote
            $vote = new Vote;

            $vote->user_id = Auth::id();
            $vote->reply_id = $reply->id;
        }

        // Create a new vote for this reply
        
        $vote->type = 'downvote';
        $vote->save();

        // Check if the downvoted reply is the question body of a question
        if ($reply->id === $reply->question->firstReply->id) {
            $question = $reply->question;

            // If already voted (meaning an upvote), add -2 to the number of upvotes, else -1
            if ($alreadyVoted) {
                $question->upvotes -= 2;
            } else {
                $question->upvotes -= 1;
            }

            $question->save();
        }

        Session::flash('message-success', 'Reply downvoted successfully!');
        return back();
    }

    // Unvote a reply function
    public function unvote(int $id) {
        $reply = Reply::findOrFail($id);

        // if (empty($reply)) {
        //     return back()->withErrors('Reply not found!');
        // }

        // Check if vote exists
        $vote = $reply->userVote();

        if ($vote == null) {
            return back()->withErrors('You have not voted on this reply');
        }

        // Check if the downvoted reply is the question body of a question
        if ($reply->id === $reply->question->firstReply->id) {
            $question = $reply->question;

            // If the reply was upvoted, add -1 else add 1
            if ($vote->type == 'upvote') {
                $question->upvotes -= 1;
            } else {
                $question->upvotes += 1;
            }

            $question->save();
        }

        $vote->delete();

        Session::flash('message-success', 'Reply unvoted!');
        return back();
    }
}
