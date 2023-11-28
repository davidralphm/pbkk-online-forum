<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Reply;
use App\Models\ReportedQuestion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class QuestionController extends Controller
{
    // Return home page
    public function index() {
        // Yesterday time
        $yesterdayDate = date('Y-m-d', strtotime('yesterday')) . ' 00:00:00';

        // Most upvoted questions
        $mostUpvotedQuestions = Question::select('questions.id', 'questions.title', 'questions.user_id', 'questions.upvotes')
        ->leftJoin('replies', 'replies.question_id', '=', 'questions.id')
        ->groupBy('questions.id')
        ->orderByDesc('upvotes')
        ->take(20)
        ->get();

        // Most active questions in the last 24 hours
        // Sorted based on number of replies in the last 24 hours
        $mostActiveQuestions = Question::select('questions.id', 'questions.title', 'questions.user_id', 'upvotes')
        ->join('replies', 'replies.question_id', '=', 'questions.id')
        ->whereDate('replies.updated_at', '>=', $yesterdayDate)
        ->get()
        ->groupBy('id')
        ->sortDesc()
        ->take(20);

        // Newest questions
        $newestQuestions = Question::select('id', 'title', 'user_id', 'upvotes')
        ->whereDate('created_at', '>=', $yesterdayDate)
        ->orderByDesc('created_at')
        ->take(20)
        ->get();

        // Most upvoted users of all time
        $mostUpvotedUsers = User::select('users.id', 'users.name')
        ->join('replies', 'replies.user_id', '=', 'users.id')
        ->join('votes', 'votes.reply_id', '=', 'replies.id')
        ->where('votes.type', '=', 'upvote')
        ->get()
        ->groupBy('id')
        ->sortDesc()
        ->take(20);

        // Most upvoted users of in the last 24 hours
        $mostUpvotedUsers24Hours = User::select('users.id', 'users.name')
        ->join('replies', 'replies.user_id', '=', 'users.id')
        ->join('votes', 'votes.reply_id', '=', 'replies.id')
        ->where('votes.type', '=', 'upvote')
        ->whereDate('votes.created_at', '>=', $yesterdayDate)
        ->get()
        ->groupBy('id')
        ->sortDesc()
        ->take(20);

        // Most active users in the last 24 hours
        // Sorted based on the number of replies made by each user
        $mostActiveUsers = User::select('users.id', 'users.name', 'replies.body')
        ->join('replies', 'replies.user_id', '=', 'users.id')
        ->whereDate('replies.updated_at', '>=', $yesterdayDate)
        ->get()
        ->groupBy('id')
        ->sortDesc()
        ->take(20);

        // Newest users
        $newestUsers = User::select('id', 'name', 'created_at')
        ->whereDate('created_at', '>=', $yesterdayDate)
        ->orderByDesc('created_at')
        ->get()
        ->take(20);

        return view(
            'homepage',
            [
                'mostUpvotedQuestions' => $mostUpvotedQuestions,
                'mostActiveQuestions' => $mostActiveQuestions,
                'newestQuestions' => $newestQuestions,

                'mostUpvotedUsers' => $mostUpvotedUsers,
                'mostActiveUsers' => $mostActiveUsers,
                'newestUsers' => $newestUsers,
            ]
        );
    }

    // Search page
    public function search(Request $request) {
        $page = $request->page ?? 1;

        $questions = Question::where('title', 'LIKE', '%' . $request->search . '%')
        ->simplePaginate(20);

        return view('searchpage', ['questions' => $questions]);
    }

    // Show create question page
    public function create() {
        return view('question.create');
    }

    // Store new question
    public function createPost(Request $request) {
        $validated = $request->validate(
            [
                'title' => 'required',
                'body' => 'required'
            ],

            [
                'title.required' => 'Harap isikan judul pertanyaan',
                'body.required' => 'Harap isikan teks pertanyaan',
            ]
        );

        $question = new Question;

        $question->user_id = Auth::id();
        $question->title = $request->title;
        $question->upvotes = 0;

        $question->save();

        // Create first reply (the body of the question)
        $reply = new Reply;

        $reply->user_id = $question->user_id;
        $reply->question_id = $question->id;
        $reply->body = $request->body;

        $reply->save();

        Session::flash('message-success', 'Question successfully created!');
        return redirect('/question/view/' . $question->id);
    }

    // Show a question
    public function view(int $id) {
        $question = Question::findOrFail($id);

        // if (empty($question)) {
        //     return back()->withErrors('Question not found!');
        // }

        $replies = $question->replies()->simplePaginate(20);

        return view('question.view', ['question' => $question, 'replies' => $replies]);
    }

    // Reply to a question
    public function reply(Request $request, int $id) {
        $question = Question::findOrFail($id);

        // if (empty($question)) {
        //     return back()->withErrors('Question not found!');
        // }

        // Make sure the question is not locked
        if ($question->locked == true) {
            return back()->withErrors('Question is locked!');
        }

        $validated = $request->validate(
            [ 'body' => 'required' ],
            [ 'body.required' => 'Harap isikan teks pertanyaan',]
        );

        $reply = new Reply;

        $reply->user_id = Auth::id();
        $reply->question_id = $id;
        $reply->body = $request->body;

        $reply->save();

        Session::flash('message-success', 'Reply posted successfully!');
        return back();
    }

    // Return edit question view
    public function edit($id) {
        $question = Question::findOrFail($id);

        // if (empty($question)) {
        //     return back()->withErrors('Question not found!');
        // }

        // Authorization
        if (Gate::none(['is-question-owner', 'is-admin'], $question)) {
            abort(401);
        }

        return view('question.edit', ['question' => $question]);
    }

    // Edit question post
    public function editPost(Request $request, int $id) {
        $question = Question::findOrFail($id);

        // if (empty($question)) {
        //     return back()->withErrors('Question not found!');
        // }

        // Authorization
        if (Gate::none(['is-question-owner', 'is-admin'], $question)) {
            abort(401);
        }

        $validated = $request->validate(
            ['title' => 'required'],
            ['title.required' => 'Harap isikan judul pertanyaan']
        );

        $question->title = $request->title;
        $question->save();

        Session::flash('message-success', 'Question edited successfully!');
        return back();
    }

    // Function to lock a question
    public function lock(Request $request, int $id) {
        $question = Question::findOrFail($id);

        // if (empty($question)) {
        //     return back()->withErrors('Question not found!');
        // }

        // Authorization
        if (Gate::none(['is-question-owner', 'is-admin'], $question)) {
            abort(401);
        }

        $question->locked = true;
        $question->save();

        Session::flash('message-success', 'Question locked successfully!');
        return back();
    }

    // Function to unlock a question
    public function unlock(Request $request, int $id) {
        $question = Question::findOrFail($id);

        // if (empty($question)) {
        //     return back()->withErrors('Question not found!');
        // }

        // Authorization
        if (Gate::none(['is-question-owner', 'is-admin'], $question)) {
            abort(401);
        }

        $question->locked = false;
        $question->save();

        Session::flash('message-success', 'Question unlocked successfully!');
        return back();
    }

    // Function to report a question
    public function report(int $id) {
        $question = Question::findOrFail($id);

        return view('report.question', ['question' => $question]);
    }

    // Report question post
    public function reportPost(Request $request, int $id) {
        $question = Question::findOrFail($id);

        $validated = $request->validate(
            ['reason' => 'required'],
            ['reason.required' => 'Reporting reason is required']
        );

        // Check if the user has already reported this question
        $report = $question->userReport();

        if ($report != null) {
            return back()->withErrors('You have already reported this question!');
        }

        // Create the report
        $report = new ReportedQuestion;

        $report->user_id = Auth::id();
        $report->reported_id = $question->id;
        $report->reason = $request->reason;

        $report->save();

        Session::flash('message-success', 'Question reported successfully!');
        return back();
    }

    // Function to remove a report
    public function removeReport(int $id) {
        $question = Question::findOrFail($id);

        $report = $question->userReport();

        if ($report == null) {
            return back()->withErrors('You have not reported this question!');
        }

        $report->delete();

        Session::flash('message-success', 'Removed report successfully!');
        return back();
    }

    // Function to show all reported questions
    public function reportedList(Request $request) {
        // Manual pagination
        $page = $request->page ?? 1;

        $reported = ReportedQuestion::all()->groupBy('reported_id')->sortDesc();

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

        return view('question.reportedList', ['reported' => $reported]);
    }

    // Function to show all the reports for a reported question
    public function reportedListView(Request $request, int $id) {
        $question = Question::findOrFail($id);

        $reports = $question->reports()->simplePaginate(20);

        return view('question.reportedListView', ['question' => $question, 'reports' => $reports]);
    }
}
