<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class BaseException extends HttpException
{
    public function __construct(string $message)
    {
        parent::__construct($this->setCode(), $message);
    }

    /**
     * 设置错误码
     *
     * @return int
     */
    abstract public function setCode(): int;
}
