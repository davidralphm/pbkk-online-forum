<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    public function question() : BelongsTo {
        return $this->belongsTo(Question::class);
    }

    public function parentPost() : BelongsTo {
        return $this->belongsTo(Post::class, 'parent_post_id');
    }

    public function childPosts() : HasMany {
        return $this->hasMany(Post::class, 'parent_post_id');
    }
}
