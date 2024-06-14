<?php

namespace Modules\Sms\Services;

use Exception;
use Modules\Sms\Facades\Sms;

class SendSmsService
{
    public function __construct()
    {
    }

    public static function send($phone, $name, $token)
    {
        try {
            $notification = trans("notifications.messages.$name");
            $count = substr_count($notification, '%TOKEN');
            $content = $notification;
            for ($j = 0; $j < $count; $j++) {
                $content = preg_replace('/\%TOKEN/', $token[$j], $content, 1);
            }
            Sms::send($phone, $content);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
