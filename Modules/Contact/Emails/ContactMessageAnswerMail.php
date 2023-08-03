<?php

namespace Modules\Contact\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactMessageAnswerMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $message_data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message_data)
    {

        $this->message_data = $message_data;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('contact::mails.message-answer-mail')->subject("پاسخ پیام");
    }
}
