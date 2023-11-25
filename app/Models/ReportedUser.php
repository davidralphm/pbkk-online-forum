<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportedUser extends Model
{
    use HasFactory;

    protected $table = 'reported_users';

    // Return the user the reported the question
    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    // Return the reported question
    public function reportedUser() : BelongsTo {
        return $this->belongsTo(User::class, 'reported_id');
    }
}
