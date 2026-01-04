<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Lang;

class QueuedResetPassword extends ResetPassword implements ShouldQueue
{
    use Queueable;

    // below is for created users to set initial password by sending reset link
    protected bool $isWelcome;

    public function __construct(string $token, bool $isWelcome = false)
    {
        parent::__construct($token);
        $this->isWelcome = $isWelcome;
    }

    public function toMail($notifiable)
    {
        $mail = parent::toMail($notifiable);

        if ($this->isWelcome) {
            return $mail
                ->subject(Lang::get('Welcome to Squarely – Set your password'));
        }

        return $mail;
    }
}
