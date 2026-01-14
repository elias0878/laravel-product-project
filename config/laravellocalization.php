<?php

return [

    // اللغات المدعومة
    'supportedLocales' => [
        'ar' => ['name' => 'Arabic', 'script' => 'Arab', 'native' => 'العربية', 'regional' => 'ar_AE'],
        'en' => ['name' => 'English', 'script' => 'Latn', 'native' => 'English', 'regional' => 'en_GB'],
    ],

    // تحديد اللغة تلقائياً من متصفح المستخدم
    'useAcceptLanguageHeader' => true,

    // إخفاء اللغة الافتراضية من الرابط
    'hideDefaultLocaleInURL' => false,

    // ترتيب اللغات في قائمة التبديل
    'localesOrder' => [],

    // ربط اللغات
    'localesMapping' => [],

    // لاحقة الترميز
    'utf8suffix' => env('LARAVELLOCALIZATION_UTF8SUFFIX', '.UTF-8'),

    // الروابط التي يجب تجاهلها
    'urlsIgnored' => ['/skipped'],

    'httpMethodsIgnored' => ['POST', 'PUT', 'PATCH', 'DELETE'],
];
