<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    // Return user yang memiliki question
    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    // Return semua reply untuk question
    public function replies() : HasMany {
        return $this->hasMany(Reply::class);
    }

    // Return body dari question
    public function firstReply() : HasOne {
        return $this->hasOne(Reply::class)->oldestOfMany();
    }
}
