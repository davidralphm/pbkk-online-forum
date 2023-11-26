<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'about',
        'image_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Return semua questions yang dimiliki user
    public function questions() : HasMany {
        return $this->hasMany(Question::class);
    }

    // Return semua replies yang dimiliki user
    public function replies() : HasMany {
        return $this->hasMany(Reply::class);
    }

    // Return the current authenticated user's report for this user
    public function userReport() {
        return ReportedUser::where('reported_id', $this->id)->where('user_id', Auth::id())->first();
    }

    // Return all the reports for this user
    public function reports() : HasMany {
        return $this->hasMany(ReportedUser::class, 'reported_id');
    }
}
