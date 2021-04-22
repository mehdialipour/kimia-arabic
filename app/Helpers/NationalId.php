<?php

namespace App\Helpers;

use App\Helpers\ConvertNumber;
use App\Models\Patient;

class NationalId
{
    public static function isValid($national_id)
    {
        $national_id = ConvertNumber::convert($national_id);
        
        if (strlen($national_id) !== 10) {
            return 'length_error';
        }

        $sum = 0;
        $j=10;

        for ($i=0; $i<9; $i++) {
            $sum = $sum + ($national_id[$i]*$j);
            $j-=1;
        }

        if (11-fmod($sum, 11) == $national_id[9] || (fmod($sum, 11) == 0 && $national_id[9] == 0) || fmod($sum, 11) == $national_id[9]) {
            if (Patient::where('national_id', $national_id)->count() > 0) {
                return 'repeat';
            } else {
                return 'valid';
            }
        } else {
            return "not_valid";
        }
    }
}
