<?php

namespace App\Enums;

final class ErrCodeEnum extends BaseEnum
{
    /*
    |--------------------------------------------------------------------------
    | 全局错误码
    |--------------------------------------------------------------------------
    */
    /** 认证失败 */
    const UNAUTHORIZED = 401;

    /** 密码已过期 */
    const PASSWORD_EXPIRED = 402;

    /** 没有权限 */
    const HTTP_AUTHORIZATION = 403;

    /** 路由错误 */
    const HTTP_NOT_FOUND = 404;

    /** 请求方式错误 */
    const METHOD_NOT_ALLOWED = 405;

    /** 请求不合法 */
    const ILLEGAL_ERROR = 406;

    /** 数据不存在 */
    const DATA_NOT_FOUND = 410;

    /** 暂无数据 */
    const DATA_EMPTY = 412;

    /** 字段验证失败 */
    const VALIDATION_FAILED = 422;

    /** 请求出错 */
    const REQUEST_ERROR = 519;

    /*
    |--------------------------------------------------------------------------
    | 自定义错误码
    |--------------------------------------------------------------------------
    |
    | 没有特殊情况直接使用默认code，然后自定义消息，例如：
    |    abort(ErrCode::ERROR_DEFAULT, '您有一个自定义错误消息')
    | 如果需要前端单独处理时，再按顺序增加自定义错误码。
    | 自定义错误码常量以ERROR_开头，值必须在540~599之间，不能重复。
    |
    */
    /** 业务默认错误码 */
    const ERROR_DEFAULT = 510;
}
