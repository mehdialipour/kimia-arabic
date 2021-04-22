<?php

namespace App\Helpers;

class ConvertNumber
{
    public static function convert($number)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic  = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        $num = range(0, 9);
        $number = str_replace($persian, $num, $number);

        $number = str_replace($arabic, $num, $number);

        return $number;
    }

    public static function convertToPersian($number)
    {
        $num = range(0, 9);
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

        $number = str_replace($num, $persian, $number);

        return $number;
    }
}
