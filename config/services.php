<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY', null),
        'secret' => env('STRIPE_SECRET', null),
        // 'webhook' => [
        //     'secret' => env('STRIPE_WEBHOOK_SECRET'),
        //     'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        // ],
    ],

    'activecampaign' => [
        'api_url' => env('ACTIVECAMPAIGN_URL'),
        'api_key' => env('ACTIVECAMPAIGN_API_KEY')
    ],

    'shareasale' => [
        'merchant_id' => env('SHARE_MERCHANT_ID'),
        'token' => env('SHARE_SALE_API_TOKEN'),
        'secret' => env('SHARE_SALE_API_SECRET'),
        'version' => env('SHARE_SALE_API_VERSION'),
    ],

    'recaptcha' => [
        'api' => env('RECAPTCHA_API'),
        'site_key' => env('RECAPTCHA_SITE_KEY'),
        'secret_key' => env('RECAPTCHA_SECRET_KEY'),
    ],

];
