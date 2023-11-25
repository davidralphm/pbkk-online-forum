<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportedReply extends Model
{
    use HasFactory;

    protected $table = 'reported_replies';

    // Return the user the reported the question
    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    // Return the reported question
    public function reportedReply() : BelongsTo {
        return $this->belongsTo(Reply::class, 'reported_id');
    }
}
