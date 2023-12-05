<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use App\Models\User;
// use Illuminate\Auth\Events\Registered;

class sendEmailWelcome implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void



    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // $user = $this->user;
        // Mail::to($user->email)->send(new WelcomeEmail($user));
        // Create the email
        $email = new WelcomeEmail();
        Mail::to($this->details['email'])->send($email);



        // Check if the email was sent successfully
        // if ($mail->sent()) {
        //     // Do something
        // }
    }
}
