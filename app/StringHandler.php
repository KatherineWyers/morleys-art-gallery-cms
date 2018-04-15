<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StringHandler extends Model
{
    /**
     * The attributes that are mass assignable.
     * NULL or Non-numeric input returns 00
     * Numeric values over 99 return 00
     * Values 0-9 returns the value as string with leading zero
     * Values 10-99 returns the value as string
     * Value below 0 returns 00 as string 
     *
     * @var array
     */

    public static function addLeadingZeroFrom0To99($input)
    {
        if(is_null($input) || (!is_numeric($input)) || ($input >= 100))
        {
            return '00';
        }

        $input = floor($input);

        if($input < 0)
        {
            return '00';
        }

        if($input < 10)
        {
            return '0' . $input;
        }

        return (string)$input;
    }
}
