<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Vote extends Model
{
    use HasFactory;

    protected $table = 'votes';

    // Function to get the user that voted
    public function user() : HasOne {
        return $this->hasOne(User::class);
    }

    // Function to get the reply that was voted
    public function reply() : HasOne {
        return $this->hasOne(Reply::class);
    }
}
