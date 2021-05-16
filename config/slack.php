<?php

return [
    // Webhook URL
    'url' => env('PAY_SLACK_WEBHOOK_URL'),

    // チャンネル設定
    'default' => 'payment',

    'channels' => [
        'billing' => [
            'username' => '課金通知',
            'icon' => ':smiley:',
            'channel' => 'payment',
        ],
        'recharge' => [
            'username' => '再課金通知',
            'icon' => ':kissing_heart:',
            'channel' => 'payment',
        ],
        'change' => [
            'username' => '変更通知',
            'icon' => ':simple_smile:',
            'channel' => 'payment',
        ],
        'cancel' => [
            'username' => 'キャンセル通知',
            'icon' => ':sob:',
            'channel' => 'payment',
        ],
    ],
];
