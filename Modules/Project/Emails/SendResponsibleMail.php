<?php

namespace Modules\Project\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendResponsibleMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->data->title;
        $project_name = $this->data->project->title;
        $issue_id = $this->data->id;
        $tracker = $this->data->tracker->title;

        return $this
            ->subject("[  $project_name - # $tracker $issue_id] $subject")
            ->markdown('project::emails.board.issue.responsible');
    }
}
