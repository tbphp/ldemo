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

    'accepted' => ':attribute必須接受',
    'active_url' => ':attribute必須是一個合法的URL',
    'after' => ':attribute必須是:date之後的一個日期',
    'after_or_equal' => ':attribute必須是:date之後或相同的一個日期',
    'alpha' => ':attribute只能包含字母',
    'alpha_dash' => ':attribute只能包含字母、數字、中劃線或下劃線',
    'alpha_num' => ':attribute只能包含字母和數字',
    'array' => ':attribute必須是一個數組',
    'before' => ':attribute必須是:date之前的一個日期',
    'before_or_equal' => ':attribute必須是:date之前或相同的一個日期',
    'between' => [
        'numeric' => ':attribute必須在:min到:max之間',
        'file' => ':attribute必須在:min到:maxKB之間',
        'string' => ':attribute必須在:min到:max個字符之間',
        'array' => ':attribute必須在:min到:max項之間',
    ],
    'boolean' => ':attribute字符必須是true或false,1或0',
    'confirmed' => ':attribute二次確認不匹配',
    'date' => ':attribute必須是一個合法的日期',
    'date_equals' => ':attribute必須是與:date相同的日期',
    'date_format' => ':attribute與給定的格式:format不符合',
    'different' => ':attribute必須不同於:other',
    'digits' => ':attribute必須是:digits位',
    'digits_between' => ':attribute必須在:min和:max位之間',
    'dimensions' => ':attribute具有無效的圖片尺寸',
    'distinct' => ':attribute字段具有重複值',
    'email' => ':attribute必須是一個合法的電子郵件地址',
    'ends_with' => ':attribute必須以:values之一結尾',
    'exists' => '選定的:attribute是無效的',
    'file' => ':attribute必須是一個文件',
    'filled' => ':attribute的字段是必填的',
    'gt' => [
        'numeric' => ':attribute必須大於:value',
        'file' => ':attribute必須大於:valueKB',
        'string' => ':attribute必須大於:value個字符',
        'array' => ':attribute必須多於:value項',
    ],
    'gte' => [
        'numeric' => ':attribute必須大於或等於:value',
        'file' => ':attribute必須大於或等於:valueKB',
        'string' => ':attribute必須大於或等於:value個字符',
        'array' => ':attribute必須多於或等於:value項',
    ],
    'image' => ':attribute必須是jpeg,png,bmp或者gif格式的图片',
    'in' => '選定的:attribute是無效的',
    'in_array' => ':attribute字段不存在於:other',
    'integer' => ':attribute必須是個整数',
    'ip' => ':attribute必須是一個合法的IP地址',
    'ipv4' => ':attribute必須是一個合法的IPv4地址',
    'ipv6' => ':attribute必須是一個合法的IPv6地址',
    'json' => ':attribute必須是一個合法的JSON字符串',
    'lt' => [
        'numeric' => ':attribute必須小於:value',
        'file' => ':attribute必須小於:valueKB',
        'string' => ':attribute必須小於:value個字符',
        'array' => ':attribute必須少於:value項',
    ],
    'lte' => [
        'numeric' => ':attribute必須小於或等於:value',
        'file' => ':attribute必須小於或等於:valueKB',
        'string' => ':attribute必須小於或等於:value個字符',
        'array' => ':attribute必須少於或等於:value項',
    ],
    'max' => [
        'numeric' => ':attribute的最大長度為:max位',
        'file' => ':attribute的最大為:max',
        'string' => ':attribute的最大長度為:max字符',
        'array' => ':attribute的最大個数為:max個',
    ],
    'mimes' => ':attribute的文件類型必須是:values',
    'mimetypes' => ':attribute的文件類型必須是:values',
    'min' => [
        'numeric' => ':attribute的最小長度為:min位',
        'file' => ':attribute大小至少為:minKB',
        'string' => ':attribute的最小長度為:min字符',
        'array' => ':attribute至少有:min項',
    ],
    'multiple_of' => ':attribute字段必須是:value的倍数',
    'not_in' => '選定的:attribute是無效的',
    'not_regex' => ':attribute格式錯誤',
    'numeric' => ':attribute必須是數字',
    'password' => '密碼錯誤',
    'present' => ':attribute字段必須存在',
    'regex' => ':attribute格式是無效的',
    'required' => ':attribute字段是必須的',
    'required_if' => '当:other是:value时，:attribute字段是必須的',
    'required_unless' => '当:other不在:values中时，:attribute字段是必須的',
    'required_with' => '当:values存在时，:attribute字段是必須的',
    'required_with_all' => '当:values都存在时，:attribute字段是必須的',
    'required_without' => '当:values不存在时，:attribute字段是必須的',
    'required_without_all' => '当没有一個:values存在时，:attribute字段是必須的',
    'prohibited' => ':attribute字段被禁止',
    'prohibited_if' => '当:other是:value时，:attribute字段被禁止',
    'prohibited_unless' => '当:other不在:values中时，:attribute字段被禁止',
    'same' => ':attribute和:other必須匹配',
    'size' => [
        'numeric' => ':attribute必須是:size',
        'file' => ':attribute必須是:sizeKB',
        'string' => ':attribute必須是:size個字符',
        'array' => ':attribute必須包括:size項',
    ],
    'starts_with' => ':attribute必須以:values之一开头',
    'string' => ':attribute必須是一個字符串',
    'timezone' => ':attribute必須是個有效的时区',
    'unique' => ':attribute已存在',
    'uploaded' => ':attribute上傳失败',
    'url' => ':attribute無效的格式',
    'uuid' => ':attribute必須是一個有效的UUID',

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
