<?php

return [
    // Webhook URL
    'url' => env('PAY_SLACK_WEBHOOK_URL'),

    // チャンネル設定
    'default' => 'notification',

    'channels' => [
        'register' => [
            'username' => '登録申請',
            'icon' => ':smiley:',
            'channel' => 'notification',
        ],
        'billing' => [
            'username' => '課金通知',
            'icon' => ':smiley:',
            'channel' => 'notification',
        ],
        'recharge' => [
            'username' => '再課金通知',
            'icon' => ':kissing_heart:',
            'channel' => 'notification',
        ],
        'change' => [
            'username' => '変更通知',
            'icon' => ':simple_smile:',
            'channel' => 'notification',
        ],
        'cancel' => [
            'username' => 'キャンセル通知',
            'icon' => ':sob:',
            'channel' => 'notification',
        ],
    ],
];
