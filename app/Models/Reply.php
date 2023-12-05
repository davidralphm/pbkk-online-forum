<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewReplyNotification;

class Reply extends Model
{
    use HasFactory;

    protected $table = 'replies';

    // Return user pemilik reply
    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    // public function sendNewReplyNotification()
    // {
    //     $this->question->user->notify(new NewReplyNotification($this));
    // }

    // Return question yang direply
    public function question() : BelongsTo {
        return $this->belongsTo(Question::class);
    }

    // Return the current authenticated user's vote for this reply
    public function userVote() {
        return Vote::where('reply_id', $this->id)->where('user_id', Auth::id())->first();
    }

    // Return the current authenticated user's report for this reply
    public function userReport() {
        return ReportedReply::where('reported_id', $this->id)->where('user_id', Auth::id())->first();
    }

    // Return all the reports for this reply
    public function reports() : HasMany {
        return $this->hasMany(ReportedReply::class, 'reported_id');
    }
}
