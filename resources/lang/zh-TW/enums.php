<?php

use App\Enums\ErrCodeEnum;

return [
    ErrCodeEnum::class => [
        ErrCodeEnum::UNAUTHORIZED => '認證失敗',
        ErrCodeEnum::PASSWORD_EXPIRED => '密碼已過期',
        ErrCodeEnum::HTTP_AUTHORIZATION => '沒有權限',
        ErrCodeEnum::HTTP_NOT_FOUND => '路由錯誤',
        ErrCodeEnum::DATA_EMPTY => '暫無數據',
        ErrCodeEnum::METHOD_NOT_ALLOWED => '請求方式錯誤',
        ErrCodeEnum::ILLEGAL_ERROR => '請求不合法',
        ErrCodeEnum::DATA_NOT_FOUND => '數據不存在',
        ErrCodeEnum::VALIDATION_FAILED => '字段驗證失敗',
        ErrCodeEnum::ERROR_DEFAULT => '業務異常，服務端沒有響應。',
    ],
];
