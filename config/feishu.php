<?php
/**
 * 飞书相关配置
 */

return [
    'api_url' => env('FEISHU_API_URL'),
    'channel' => [
        // 监控频道（默认）
        'monitor' => [
            'token' => env('FEISHU_MONITOR_TOKEN'),
            'secret' => env('FEISHU_MONITOR_SECRET'),
        ],
    ],
];
