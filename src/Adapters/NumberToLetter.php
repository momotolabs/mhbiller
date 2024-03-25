<?php

namespace Momotolabs\Mhbiller\Adapters;

use NumberToWords\NumberToWords;

final class NumberToLetter
{
    public static function make($value)
    {
        return NumberToWords::transformCurrency('es', $value,'USD');

    }

}
