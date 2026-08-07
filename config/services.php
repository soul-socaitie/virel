<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'telegram' => [
    'bot_token' => env('TELEGRAM_BOT_TOKEN'),
    'secret' => env('TELEGRAM_WEBHOOK_SECRET'),
    ],

    'openrouter' => [
    'api_key' => env('OPENROUTER_API_KEY'),
    'model' => env(
        'OPENROUTER_MODEL',
        'deepseek/deepseek-chat-v3.1:free'
        ),
    ],

]; 