<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportedQuestion extends Model
{
    use HasFactory;

    protected $table = 'reported_questions';

    // Return the user the reported the question
    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    // Return the reported question
    public function reportedQuestion() : BelongsTo {
        return $this->belongsTo(Question::class, 'reported_id');
    }
}
