<?php

namespace Modules\Auth\Notifications\v1\App;

use Illuminate\Bus\Queueable;
use Modules\Auth\Emails\VerifyCodeMail;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyMailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $code;
    public $email;

    public function __construct($email, $code)
    {
        $this->code = $code;
        $this->email = $email;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new VerifyCodeMail($this->code))->to($this->email);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
