<?php

namespace Modules\Sms\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSmsJob implements ShouldQueue
{
    public $phone;
    public $content;
    public $driverInstance;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($phone, $content, $driverInstance)
    {
        $this->phone = $phone;
        $this->content = $content;
        $this->driverInstance = $driverInstance;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->driverInstance->send($this->phone, $this->content);
    }
}
