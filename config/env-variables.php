<?php

return [
    'APP_URL' => env('APP_URL', 'https://debutify.com'),
    'APP_TRACKING' => env('APP_TRACKING', false),
    'APP_PATH' => env('APP_PATH', ''),
    'APP_DEMO' => env('APP_DEMO', ''),
    'APP_REVIEW_FORM' => env('APP_REVIEW_FORM', ''),
    'TRIAL_COUPON' => env('TRIAL_COUPON', ''),
    'ASSET_VERSION' => env('ASSET_VERSION', ''),
    'BLOCK_CRAWLER' => env('BLOCK_CRAWLER', false),

    'SHOPIFY_API_VERSION' => env('SHOPIFY_API_VERSION', '2020-04'),
    'SHOPIFY_WEBHOOK_1_ADDRESS' => env('SHOPIFY_WEBHOOK_1_ADDRESS', 'app-uninstalled'),
    'SHOPIFY_WEBHOOK_2_ADDRESS' => env('SHOPIFY_WEBHOOK_2_ADDRESS', 'themes-delete'),
    'SHOPIFY_WEBHOOK_3_ADDRESS' => env('SHOPIFY_WEBHOOK_3_ADDRESS', 'themes-update'),
    'SHOPIFY_WEBHOOK_4_ADDRESS' => env('SHOPIFY_WEBHOOK_4_ADDRESS', 'themes-create'),
    'SHOPIFY_WEBHOOK_5_ADDRESS' => env('SHOPIFY_WEBHOOK_5_ADDRESS', 'shop-update'),

    'IMPACT_ENABLED' => env('IMPACT_ENABLED', false),
    'IMPACT_USERNAME' => env('IMPACT_USERNAME', ''),
    'IMPACT_PASSWORD' => env('IMPACT_PASSWORD', ''),

    'PAYPAL_MODE' => env('PAYPAL_MODE', ''),
    'PAYPAL_SANDBOX_URL' => env('PAYPAL_SANDBOX_URL', ''),
    'PAYPAL_SANDBOX_CLIENT_SECRET' => env('PAYPAL_SANDBOX_CLIENT_SECRET', null),
    'PAYPAL_SANDBOX_REDIRECT_URL' => env('PAYPAL_SANDBOX_REDIRECT_URL', null),
    'PAYPAL_SANDBOX_CLIENT_ID' => env('PAYPAL_SANDBOX_CLIENT_ID', null),

    'PAYPAL_LIVE_URL' => env('PAYPAL_LIVE_URL', ''),
    'PAYPAL_LIVE_CLIENT_SECRET' => env('PAYPAL_LIVE_CLIENT_SECRET', null),
    'PAYPAL_LIVE_REDIRECT_URL' => env('PAYPAL_LIVE_REDIRECT_URL', null),
    'PAYPAL_LIVE_CLIENT_ID' => env('PAYPAL_LIVE_CLIENT_ID', null),
    
    'LINKMINK_API' => env('LINKMINK_API', null),

    'DEBUTIFY_SUPPORT_EMAIL' => env('DEBUTIFY_SUPPORT_EMAIL','support@debutify.com'),
    'SENDGRID_API_KEY' => env('SENDGRID_API_KEY',null),

    'STRIPE_MODE' => env('STRIPE_MODE', ''),
    'STRIPE_KEY' => env('STRIPE_KEY', ''),
    'STRIPE_SECRET' => env('STRIPE_SECRET', ''),

    'INTERCOM_TOKEN' => env('INTERCOM_TOKEN', '')

];
