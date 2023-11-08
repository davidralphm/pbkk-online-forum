<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Question extends Model
{
    use HasFactory;

    public function firstPost() : HasOne {
        return $this->hasOne(Post::class);
    }
    public function posts() : HasMany {
        return $this->hasMany(Post::class);
    }
}
