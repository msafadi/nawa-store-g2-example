<?php

namespace App\Helpers;

use NumberFormatter;

class Money
{
    public static function format($amount, $currency = null)
    {
        $locale = config('app.locale');
        if (!$currency) {
            $currency = config('app.currency');
        }

        $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($amount, $currency);
    }
}