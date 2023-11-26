<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\ReportedReply;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class ReplyController extends Controller
{
    // Return reply edit view
    public function edit(int $id) {
        $reply = Reply::findOrFail($id);

        // if (empty($reply)) {
        //     return back()->withErrors('Reply not found!');
        // }

        // Authorization
        if (Gate::none(['is-reply-owner', 'is-admin'], $reply)) {
            abort(401);
        }

        return view('reply.edit', ['reply' => $reply]);
    }

    // Reply edit post
    public function editPost(Request $request, int $id) {
        $reply = Reply::findOrFail($id);

        // if (empty($reply)) {
        //     return back()->withErrors('Reply not found!');
        // }

        // Authorization
        if (Gate::none(['is-reply-owner', 'is-admin'], $reply)) {
            abort(401);
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
        $reply = Reply::findOrFail($id);

        // if (empty($reply)) {
        //     return back()->withErrors('Reply not found!');
        // }

        // Authorization
        if (Gate::none(['is-reply-owner', 'is-admin'], $reply)) {
            abort(401);
        }

        // Set deleted flag to true
        $reply->deleted = true;
        $reply->save();

        Session::flash('message-success', 'Reply deleted successfully!');
        return back();
    }
    
    // Undelete reply function
    public function undelete(Request $request, int $id) {
        $reply = Reply::findOrFail($id);

        // if (empty($reply)) {
        //     return back()->withErrors('Reply not found!');
        // }

        // Authorization (only admin can undelete a reply)
        Gate::authorize('is-admin');

        // Set deleted flag to true
        $reply->deleted = false;
        $reply->save();

        Session::flash('message-success', 'Reply undeleted successfully!');
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

    // Function to report a reply
    public function report(int $id) {
        $reply = Reply::findOrFail($id);

        return view('report.reply', ['reply' => $reply]);
    }

    // Report reply post
    public function reportPost(Request $request, int $id) {
        $reply = Reply::findOrFail($id);

        $validated = $request->validate(
            ['reason' => 'required'],
            ['reason.required' => 'Reporting reason is required']
        );

        // Check if the user has already reported this question
        $report = $reply->userReport();

        if ($report != null) {
            return back()->withErrors('You have already reported this reply!');
        }

        // Create the report
        $report = new ReportedReply();

        $report->user_id = Auth::id();
        $report->reported_id = $reply->id;
        $report->reason = $request->reason;

        $report->save();

        Session::flash('message-success', 'Reply reported successfully!');
        return back();
    }

    // Function to remove a report
    public function removeReport(int $id) {
        $reply = Reply::findOrFail($id);

        $report = $reply->userReport();

        if ($report == null) {
            return back()->withErrors('You have not reported this reply!');
        }

        $report->delete();

        Session::flash('message-success', 'Removed report successfully!');
        return back();
    }

    // Function to show all reported replies
    public function reportedList(Request $request) {
        $page = $request->page ?? 1;

        $reported = ReportedReply::all()->groupBy('reported_id')->sortDesc();

        $reported = new LengthAwarePaginator(
            $reported->slice($page * 20 - 20, 20),
            $reported->count(),
            20,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query()
            ]
        );

        return view('reply.reportedList', ['reported' => $reported]);
    }

    // Function to show all the reports for a reported reply
    public function reportedListView(Request $request, int $id) {
        $reply = Reply::findOrFail($id);

        $reports = $reply->reports()->simplePaginate(20);

        return view('reply.reportedListView', ['reply' => $reply, 'reports' => $reports]);
    }
}
