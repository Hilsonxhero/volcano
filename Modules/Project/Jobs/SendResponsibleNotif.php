<?php

namespace Modules\Project\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Sms\Services\SendSmsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Project\Emails\SendResponsibleMail;

class SendResponsibleNotif implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $phone;
    public $issue;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($phone, $issue)
    {
        $this->phone = $phone;
        $this->issue = $issue;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Mail::to($this->email)->send(new SendResponsibleMail($this->issue));

        SendSmsService::send(
            $this->phone,
            "project_issue_user_responsible",
            [
                $this->issue->id,
                $this->issue->creator->username,
                $this->issue->tracker->title . " " . $this->issue->id . "# " . ": " . $this->issue->title,
                front_path("portal/projects/{$this->issue->project->id}/issues/{$this->issue->id}")
            ]
        );
    }
}
