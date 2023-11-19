<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class QuestionController extends Controller
{
    // Return home page
    public function index() {

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

    // Show the first page of a question
    public function view(int $id) {
        $question = Question::find($id);

        if (empty($question)) {
            Session::flash('message-error', 'Question does not exist!');
            return redirect('/');
        }

        $replies = $question->replies()->limit(20)->get();

        return view('question.view', ['question' => $question, 'replies' => $replies]);
    }

    // Show a specific page of a question
    public function viewPage(int $id, int $page) {
        $question = Question::find($id);

        if (empty($question)) {
            Session::flash('message-error', 'Question does not exist!');
            return redirect('/');
        }

        $replies = $question->replies()->offset($page * 20)->limit(20)->get();

        return view('question.view', ['question' => $question, 'replies' => $replies]);
    }

    // Reply to a question
    public function reply(Request $request, int $id) {
        $question = Question::find($id);

        if (empty($question)) {
            Session::flash('message-error', 'Question does not exist!');
            return redirect('/');
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
}
