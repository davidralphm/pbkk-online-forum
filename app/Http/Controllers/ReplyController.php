<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
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
}
