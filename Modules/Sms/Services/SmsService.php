<?php

namespace Modules\Sms\Services;

use Modules\Sms\Jobs\SendSmsJob;

class SmsService
{
    /**
     * Payment Driver Name.
     *
     * @var string
     */
    protected $driver;


    /**
     * Sms Driver Instance.
     *
     * @var object
     */
    protected $driverInstance;

    public function __construct()
    {
        $this->via(config('sms.default'));
    }

    protected function getFreshDriverInstance()
    {
        $class = config('sms.map')[$this->driver];
        return new $class();
    }

    public function via($driver)
    {
        $this->driver = $driver;
        return $this;
    }

    public function send($phone, $content)
    {
        $this->driverInstance = $this->getFreshDriverInstance();

        // $this->driverInstance->send($phone, $content);
        SendSmsJob::dispatch($phone, $content, $this->driverInstance);

        return $this;
    }
}
