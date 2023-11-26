<?php

namespace App\Providers;

use App\Models\Question;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Question authorization
        Gate::define('is-question-owner', function(User $user, Question $question) {
            return $user->id == $question->user_id;
        });

        // Reply authorization
        Gate::define('is-reply-owner', function(User $user, Reply $reply) {
            return $user->id == $reply->user_id;
        });

        // Admin authorization
        Gate::define('is-admin', function(User $user) {
            return $user->role == 'admin';
        });
    }
}
