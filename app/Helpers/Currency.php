<?php

namespace App\Helpers;

use NumberFormatter;

class Currency
{
    public function __invoke(...$params)
    {
        return static::format(...$params);
    }
    public static function format($amount, $currency = null)
    {
        $Formatter = new
           NumberFormatter(config('app.locale', 'en_US'),
            NumberFormatter::CURRENCY);

        if ($currency === null) {
            $currency = config('app.currency', 'USD');
        }

        return $Formatter->format($amount, $currency);
    }

}

//class Currency
//{
//    public static function format($amount, $currency = null): false|string
//    {
//        // الحصول على الـ locale من إعدادات التطبيق
//        $locale = config('app.locale');
//
//        // تحديد العملة إذا لم يتم تقديمها
//        $currency = $currency ?? config('app.currency', 'USD');
//
//        // إنشاء مثيل من NumberFormatter لتنسيق العملة
//        $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
//
//        // تنسيق وإرجاع المبلغ كعملة
//        return $formatter->formatCurrency($amount, $currency);
//    }
//}