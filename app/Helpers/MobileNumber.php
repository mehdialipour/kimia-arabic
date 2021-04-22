<?php

namespace App\Helpers;

use App\Helpers\ConvertNumber;
use App\Services\Sms;

class MobileNumber
{
    public static function isValid($mobile)
    {
        $mobile = ConvertNumber::convert($mobile);
        if (strlen($mobile) !== 11 || $mobile[0].$mobile[1] !== "09" || !is_numeric($mobile)) {
            return 'not_valid';
        } else {
            $token = rand(1000, 9999);

            Sms::send($mobile, $token, null, null, "verify");

            return $token;
        }
    }
}
