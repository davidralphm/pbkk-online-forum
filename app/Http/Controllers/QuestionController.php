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
            return back()->withErrors('Question not found!');
        }

        $replies = $question->replies()->limit(20)->get();

        return view('question.view', ['question' => $question, 'replies' => $replies]);
    }

    // Show a specific page of a question
    public function viewPage(int $id, int $page) {
        $question = Question::find($id);

        if (empty($question)) {
            return back()->withErrors('Question not found!');
        }

        $replies = $question->replies()->offset($page * 20)->limit(20)->get();

        return view('question.view', ['question' => $question, 'replies' => $replies]);
    }

    // Reply to a question
    public function reply(Request $request, int $id) {
        $question = Question::find($id);

        if (empty($question)) {
            return back()->withErrors('Question not found!');
        }

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
        $question = Question::find($id);

        if (empty($question)) {
            return back()->withErrors('Question not found!');
        }

        return view('question.edit', ['question' => $question]);
    }

    // Edit question post
    public function editPost(Request $request, int $id) {
        $question = Question::find($id);

        if (empty($question)) {
            return back()->withErrors('Question not found!');
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
        $question = Question::find($id);

        if (empty($question)) {
            return back()->withErrors('Question not found!');
        }

        $question->locked = true;
        $question->save();

        Session::flash('message-success', 'Question locked successfully!');
        return back();
    }
}
