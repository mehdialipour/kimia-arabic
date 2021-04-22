<?php

namespace App\Services;

use App\Models\Setting;

class Sms
{
    public static function send($receptor, $token, $token2='', $token3='', $template)
    {
        $credit = Setting::first()->credit;
        if ($credit > -200000) {
            $url = urldecode("https://api.kavenegar.com/v1/774D2B6B6E51373872514E6A594A6C7772614356675034412F34793769426254/verify/lookup.json?receptor=$receptor&token=$token&token2=$token2&token3=$token3&template=$template");
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_AUTOREFERER, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        
            $data = curl_exec($ch);
            curl_close($ch);
            $result = explode('"cost":', $data);
        
            if (isset($result[1])) {
                $string = explode("}]}", $result[1]);
                $string = intval($string[0])*1.7;
            } else {
                $string = 426*1.7;
            }
            Setting::where('id', '>', 0)->update([
                'credit' => $credit-$string
            ]);

            // dd($string);
        }
    }

    public static function futureTurn($receptor, $token, $token2='', $token10='', $template)
    {
        $credit = Setting::first()->credit;
        if ($credit > -200000) {
            $url = urldecode("https://api.kavenegar.com/v1/774D2B6B6E51373872514E6A594A6C7772614356675034412F34793769426254/verify/lookup.json?receptor=$receptor&token=$token&token2=$token2&token10=$token10&template=$template");
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_AUTOREFERER, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

            $data = curl_exec($ch);
            curl_close($ch);

            $result = explode('"cost":', $data);
        
            $string = explode("}]}", $result[1]);
            $string = intval($string[0])*1.7;
            Setting::where('id', '>', 0)->update([
                'credit' => $credit-$string
            ]);
        }
    }

    public static function debt($receptor, $name, $amount)
    {
        $credit = Setting::first()->credit;
        if ($credit > -200000) {
            $setting = Setting::first();
            $card_number = $setting->card_number;
            $message = "مراجعه کننده گرامی ".$name."، لطفا نسبت به تسویه بدهی خود به مبلغ ".$amount." به ".$setting->name." به یکی از دو روش زیر اقدام نمایید.\nشماره کارت: ".$card_number."\n لینک تسویه آنلاین: \n ".$setting->payment_link."\n لطفا در صورت تسویه آنلاین مشخصات و توضیحات را تکمیل فرمایید. لطفا پس از تسویه به مرکز درمانی اطلاع دهید.\n".$setting->phone."\nنرم افزار مدیریت مراکز درمانی کیمیاطب";

            $message = urlencode($message);
            $url = "https://login.niazpardaz.ir/SMSInOutBox/SendSms?username=c.Vahidnob&password=232822&from=10009611&to=$receptor&text=$message";

            // dd($url);

            $data = file_get_contents($url);
            // dd($data);
            $string = '10000';
            Setting::where('id', '>', 0)->update([
                'credit' => $credit-$string
            ]);
        }
    }

    public static function canceledTurn($patient, $service, $date, $time, $mobile)
    {
        $credit = Setting::first()->credit;
        if ($credit > -200000) {
            $setting = Setting::first();
            $message = 'مراجعه کننده گرامی '.$patient->name.'، نوبت شما برای خدمت «'.$service->name.'» در '.$setting->name.' برای تاریخ '.$date.' ساعت '.$time.' لغو شد.';

            $message = urlencode($message);
            $url = "https://login.niazpardaz.ir/SMSInOutBox/SendSms?username=c.Vahidnob&password=232822&from=10009611&to=$patient->mobile&text=$message";

            $data = file_get_contents($url);

            $message = 'نوبت مراجعه کننده شما «'.$patient->name.'» برای خدمت «'.$service->name.'» در '.$setting->name.' برای تاریخ '.$date.' ساعت '.$time.' لغو شد.';

            $message = urlencode($message);
            $url = "https://login.niazpardaz.ir/SMSInOutBox/SendSms?username=c.Vahidnob&password=232822&from=10009611&to=$mobile&text=$message";

            // dd($url);

            $data = file_get_contents($url);
            // dd($data);
            $string = '20000';
            Setting::where('id', '>', 0)->update([
                'credit' => $credit-$string
            ]);
        }
    }
}
