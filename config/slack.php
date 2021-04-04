<?php

return [
    // Webhook URL
    'url' => env('LOG_SLACK_WEBHOOK_URL'),

    // チャンネル設定
    'default' => 'work',

    'channels' => [
        'work' => [
            'username' => '作業通知',
            'icon' => ':smiley:',
            'channel' => 'storemap-work',
        ],
        'error' => [
            'username' => 'エラー通知',
            'icon' => ':scream:',
            'channel' => 'storemap-error',
        ],
    ],
];
