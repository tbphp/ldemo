<?php

namespace App\Exceptions;

use App\Enums\ErrCodeEnum;

/**
 * 默认业务异常
 *
 * Class DefaultException
 *
 * @package App\Exceptions
 */
class DefaultException extends BaseException
{
    public function setCode(): int
    {
        return ErrCodeEnum::ERROR_DEFAULT;
    }
}
