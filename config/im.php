<?php

use App\Enums\ImGroupTypeEnum;

return [
    'app_id' => env('IM_APPID'),
    'secret_key' => env('IM_SECRET'),
    'administrator' => env('IM_ADMINISTRATOR'),
    'callback_key' => env('IM_CALLBACKKEY'),
    'cs_account' => env('IM_CS_ACCOUNT'), // 客服账号
    'groups' => [
        ImGroupTypeEnum::NORMAL => [
            'id_prefix' => '', // 群id前缀
            'administrators_max' => -1, // 管理员数量上限，-1为不限制
            'self_exit' => true, // 是否可以自己退群
            'unique' => false, // 是否唯一（指此类型的群同时只能加入一个）
        ],
        ImGroupTypeEnum::NODE => [
            'id_prefix' => 'node-',
            'administrators_max' => 5,
            'self_exit' => false,
            'unique' => true,
        ],
    ],
];
