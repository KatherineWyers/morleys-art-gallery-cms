<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MathHelper extends Model
{
    /**
     * Return a percentage, rounded down to the nearest integer
     * @var array
     */
    public static function calculatePercentage($num, $denom)
    {
        if($num <= 0 || $denom <= 0)
        {
            return 0;
        }

        if($num > $denom)
        {
            return 100;
        }
        return (int)(($num/$denom)*100);
    }
}
