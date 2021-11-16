<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'email' => [
        'master' => 'master@storemap.jp',
        'support' => 'smsupport@storemap.jp',
        'system' => 'system@storemap.jp',
        'contact' => 'contact@storemap.jp',
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],
    'GA_ENABLE' => env('GA_ENABLE'),
    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'stripe' => [
        'model' => App\Models\Company::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'light' => env('STRIPE_LIGHT_ID'),
        'basic' => env('STRIPE_BASIC_ID'),
        'premium' => env('STRIPE_PREMIUM_ID'),
        'stores' => env('STRIPE_STORES_ID'),
        'free_price' => 0,
        'light_price' => 500,
        'basic_price' => 3000,
        'premium_price' => 5000,
        'trial' => env('STRIPE_TRIAL'),
        // 'trial' => '180',
        'add_store' => 3000,
        'free_store' => 1,
        'free_item' => 10,
        'light_item' => 100,
        'basic_item' => 10000,
        'premium_item' => 50000,
        'free_storage' => 10485760, // 10MByte
        'light_storage' => 104857600, // 100MByte
         //'light_storage' => 1073741824, // 1GByte
        'basic_storage' => 10737418240, // 10GByte
        'premium_storage' => 53687091200, // 50GByte
        'free_storage_domination' => '10MByte',
        'light_storage_domination' => '100MByte', // 100MByte
        'basic_storage_domination' => '10GByte', // 10GByte
        'premium_storage_domination' => '50GByte', // 50GByte
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
        'plans' => [
            env('STRIPE_LIGHT_ID') => 'ライト',
            env('STRIPE_BASIC_ID') => 'ベーシック',
            env('STRIPE_PREMIUM_ID') => 'プレミアム'
        ],
        //'light_price' => env('STRIPE_LIGHT_PRICE'),
        //'basic_price' => env('STRIPE_BASIC_PRICE'),
        //'premium_price' =>env('STRIPE_PREMIUM_PRICE'),
        //'trial' => env('STRIPE_TRIAL'),
        //'add_store' =>env('STRIPE_ADD_STORE'),
        //'light_item' => env('STRIPE_LIGHT_ITEM'),
        //'basic_item' => env('STRIPE_BASIC_ITEM'),
        //'premium_item' =>env('STRIPE_PREMIUM_ITEM'),
        //'light_storage' => env('STRIPE_LIGHT_STORAGE'), // 100MByte
        //'basic_storage' => env('STRIPE_BASIC_STORAGE'), // 10GByte
        //'premium_storage' => env('STRIPE_PREMIUM_STORAGE'), // 50GByte
    ],
];
