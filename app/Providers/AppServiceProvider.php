<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        VerifyEmail::toMailUsing(function ($notifiable) {
            $verifyUrl = URL::temporarySignedRoute(
                'verification.verify', Carbon::now()->addMinutes(60), ['id' => $notifiable->getKey()]
            );

            return (new MailMessage())
                ->subject('Greeting from GoHundred: Please verify your email')
                ->line('Please click the button below to verify your email address.')
                ->action('Verify Email Address', $verifyUrl)
                ->line('If you did not create an account, no further action is required.');
                // ->markdown('emails.verify', ['url' => $verifyUrl]);
        });
    }

    public function register()
    {
        //
    }
}
