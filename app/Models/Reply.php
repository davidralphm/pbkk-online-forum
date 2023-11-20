<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reply extends Model
{
    use HasFactory;

    protected $table = 'replies';

    // Return user pemilik reply
    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    // Return question yang direply
    public function question() : BelongsTo {
        return $this->belongsTo(Question::class);
    }
}
