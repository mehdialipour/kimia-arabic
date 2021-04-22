<?php 
namespace App\Helpers;

use Morilog\Jalali\CalendarUtils;

class ConvertDate
{
	
	public static function toGeorgian($date)
	{
		$date = explode("-", $date);
        $g_date = CalendarUtils::toGregorian($date[0], $date[1], $date[2]);

        if($g_date[1] < 10) $g_date[1] = "0".$g_date[1];
        if($g_date[2] < 10) $g_date[2] = "0".$g_date[2];

        return $g_date;
	}

	public static function toJalali($date)
	{
		return CalendarUtils::strftime('Y-m-d', strtotime($date));
	}

	
	public static function today($date)
	{
		return date('l Y/m/d ');
	}

	public static function todayDate($date)
	{
		return CalendarUtils::strftime('Y-m-d ', strtotime($date));
	}
}