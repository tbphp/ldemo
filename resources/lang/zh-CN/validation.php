<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute必须接受',
    'active_url' => ':attribute必须是一个合法的URL',
    'after' => ':attribute必须是:date之后的一个日期',
    'after_or_equal' => ':attribute必须是:date之后或相同的一个日期',
    'alpha' => ':attribute只能包含字母',
    'alpha_dash' => ':attribute只能包含字母、数字、中划线或下划线',
    'alpha_num' => ':attribute只能包含字母和数字',
    'array' => ':attribute必须是一个数组',
    'before' => ':attribute必须是:date之前的一个日期',
    'before_or_equal' => ':attribute必须是:date之前或相同的一个日期',
    'between' => [
        'numeric' => ':attribute必须在:min到:max之间',
        'file' => ':attribute必须在:min到:maxKB之间',
        'string' => ':attribute必须在:min到:max个字符之间',
        'array' => ':attribute必须在:min到:max项之间',
    ],
    'boolean' => ':attribute字符必须是true或false,1或0',
    'confirmed' => ':attribute二次确认不匹配',
    'date' => ':attribute必须是一个合法的日期',
    'date_equals' => ':attribute必须是与:date相同的日期',
    'date_format' => ':attribute与给定的格式:format不符合',
    'different' => ':attribute必须不同于:other',
    'digits' => ':attribute必须是:digits位',
    'digits_between' => ':attribute必须在:min和:max位之间',
    'dimensions' => ':attribute具有无效的图片尺寸',
    'distinct' => ':attribute字段具有重复值',
    'email' => ':attribute必须是一个合法的电子邮件地址',
    'ends_with' => ':attribute必须以:values之一结尾',
    'exists' => '选定的:attribute是无效的',
    'file' => ':attribute必须是一个文件',
    'filled' => ':attribute的字段是必填的',
    'gt' => [
        'numeric' => ':attribute必须大于:value',
        'file' => ':attribute必须大于:valueKB',
        'string' => ':attribute必须大于:value个字符',
        'array' => ':attribute必须多于:value项',
    ],
    'gte' => [
        'numeric' => ':attribute必须大于或等于:value',
        'file' => ':attribute必须大于或等于:valueKB',
        'string' => ':attribute必须大于或等于:value个字符',
        'array' => ':attribute必须多于或等于:value项',
    ],
    'image' => ':attribute必须是jpeg,png,bmp或者gif格式的图片',
    'in' => '选定的:attribute是无效的',
    'in_array' => ':attribute字段不存在于:other',
    'integer' => ':attribute必须是个整数',
    'ip' => ':attribute必须是一个合法的IP地址',
    'ipv4' => ':attribute必须是一个合法的IPv4地址',
    'ipv6' => ':attribute必须是一个合法的IPv6地址',
    'json' => ':attribute必须是一个合法的JSON字符串',
    'lt' => [
        'numeric' => ':attribute必须小于:value',
        'file' => ':attribute必须小于:valueKB',
        'string' => ':attribute必须小于:value个字符',
        'array' => ':attribute必须少于:value项',
    ],
    'lte' => [
        'numeric' => ':attribute必须小于或等于:value',
        'file' => ':attribute必须小于或等于:valueKB',
        'string' => ':attribute必须小于或等于:value个字符',
        'array' => ':attribute必须少于或等于:value项',
    ],
    'max' => [
        'numeric' => ':attribute的最大长度为:max位',
        'file' => ':attribute的最大为:max',
        'string' => ':attribute的最大长度为:max字符',
        'array' => ':attribute的最大个数为:max个',
    ],
    'mimes' => ':attribute的文件类型必须是:values',
    'mimetypes' => ':attribute的文件类型必须是:values',
    'min' => [
        'numeric' => ':attribute的最小长度为:min位',
        'file' => ':attribute大小至少为:minKB',
        'string' => ':attribute的最小长度为:min字符',
        'array' => ':attribute至少有:min项',
    ],
    'multiple_of' => ':attribute字段必须是:value的倍数',
    'not_in' => '选定的:attribute是无效的',
    'not_regex' => ':attribute格式错误',
    'numeric' => ':attribute必须是数字',
    'password' => '密码错误',
    'present' => ':attribute字段必须存在',
    'regex' => ':attribute格式是无效的',
    'required' => ':attribute字段是必须的',
    'required_if' => '当:other是:value时，:attribute字段是必须的',
    'required_unless' => '当:other不在:values中时，:attribute字段是必须的',
    'required_with' => '当:values存在时，:attribute字段是必须的',
    'required_with_all' => '当:values都存在时，:attribute字段是必须的',
    'required_without' => '当:values不存在时，:attribute字段是必须的',
    'required_without_all' => '当没有一个:values存在时，:attribute字段是必须的',
    'prohibited' => ':attribute字段被禁止',
    'prohibited_if' => '当:other是:value时，:attribute字段被禁止',
    'prohibited_unless' => '当:other不在:values中时，:attribute字段被禁止',
    'same' => ':attribute和:other必须匹配',
    'size' => [
        'numeric' => ':attribute必须是:size',
        'file' => ':attribute必须是:sizeKB',
        'string' => ':attribute必须是:size个字符',
        'array' => ':attribute必须包括:size项',
    ],
    'starts_with' => ':attribute必须以:values之一开头',
    'string' => ':attribute必须是一个字符串',
    'timezone' => ':attribute必须是个有效的时区',
    'unique' => ':attribute已存在',
    'uploaded' => ':attribute上传失败',
    'url' => ':attribute无效的格式',
    'uuid' => ':attribute必须是一个有效的UUID',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
