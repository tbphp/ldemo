<?php

return [
    'im' => [
        'app_id' => env('IM_APPID'),
        'secret_key' => env('IM_SECRET'),
        'administrator' => env('IM_ADMINISTRATOR'),
        'callback_key' => env('IM_CALLBACKKEY')
    ],
    'bsc' => [
        'default' => env('BSC_CONNECTION', 'node'),

        'connections' => [
            'node' => [
                'url' => env('BSC_NODE_URL', ''),
            ],
            'get_block' => [
                'key' => env('BSC_GET_BLOCK_KEY', ''),
                'url' => env('BSC_GET_BLOCK_URL', ''),
            ],
        ],
    ],

    //up url
    'up' => [
        'get_transfer_list' => env('UP_URL', '') . '/nft/get_list?method=get_transfer_list',
        'notify' => env('UP_URL', '') . '/nft/notify',
        'candy_reward' => env('UP_URL', '') . '/ups/candy_reward',
    ],
];
