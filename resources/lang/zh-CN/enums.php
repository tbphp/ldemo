<?php

use App\Enums\AppVersionTypeEnum;
use App\Enums\BscTxsEnum;
use App\Enums\ErrCodeEnum;
use App\Enums\ImGroupIdentityEnum;
use App\Enums\ImGroupTypeEnum;
use App\Enums\NftFertilityRewardTypeEnum;
use App\Enums\NftGenderEnum;
use App\Enums\NftGroupRewardTypeEnum;
use App\Enums\NftHpAddTypeEnum;
use App\Enums\NftMintRewardTypeEnum;
use App\Enums\NftMintStatusEnum;
use App\Enums\NftOrderStatusEnum;
use App\Enums\NftTaskTypeEnum;
use App\Enums\RedPacketLedgerOperateEnum;
use App\Enums\RedPacketStatusEnum;
use App\Enums\RedPacketTypeEnum;
use App\Enums\TradeEnum;
use App\Enums\TransactionEnum;
use App\Enums\WalletOperateTypeEnum;

return [
    ErrCodeEnum::class => [
        ErrCodeEnum::UNAUTHORIZED => '认证失败',
        ErrCodeEnum::PASSWORD_EXPIRED => '密码已过期',
        ErrCodeEnum::HTTP_AUTHORIZATION => '没有权限',
        ErrCodeEnum::HTTP_NOT_FOUND => '路由错误',
        ErrCodeEnum::DATA_EMPTY => '暂无数据',
        ErrCodeEnum::METHOD_NOT_ALLOWED => '请求方式错误',
        ErrCodeEnum::ILLEGAL_ERROR => '请求不合法',
        ErrCodeEnum::DATA_NOT_FOUND => '数据不存在',
        ErrCodeEnum::VALIDATION_FAILED => '字段验证失败',
        ErrCodeEnum::ERROR_DEFAULT => '业务异常，服务端没有响应。',
        ErrCodeEnum::REQUEST_ERROR => '请求出错',
    ],

    AppVersionTypeEnum::class => [
        AppVersionTypeEnum::ANDROID => '安卓',
        AppVersionTypeEnum::IOS => '苹果',
    ],

    BscTxsEnum::class => [
        'status' . BscTxsEnum::STATUS_CREATE => '处理中',
        'status' . BscTxsEnum::STATUS_SUCCESS => '成功',
        'status' . BscTxsEnum::STATUS_FAIL => '失败',
    ],

    TransactionEnum::class => [
        'type' . TransactionEnum::TYPE_RECHARGE => '资产钱包转入',
        'type' . TransactionEnum::TYPE_WITHDRAW => '资产钱包转出',
        'nft_type' . TransactionEnum::TYPE_RECHARGE => '系统钱包转入',
        'nft_type' . TransactionEnum::TYPE_WITHDRAW => '系统钱包转出',
        'status' . TransactionEnum::STATUS_RECHARGE => '处理中',
        'status' . TransactionEnum::STATUS_RECHARGE_CONFIRMATION => '成功',
        'status' . TransactionEnum::STATUS_RECHARGE_FAIL => '失败',
        'status' . TransactionEnum::STATUS_WITHDRAW_AUDIT => '审核中',
        'status' . TransactionEnum::STATUS_WITHDRAWING => '处理中',
        'status' . TransactionEnum::STATUS_WITHDRAW_FINISH => '成功',
        'status' . TransactionEnum::STATUS_WITHDRAW_FAIL => '失败',
        'asset_type' . TransactionEnum::ASSET_TYPE_TOKEN => '资产',
        'asset_type' . TransactionEnum::ASSET_TYPE_NFT => 'NFT',
    ],

    TradeEnum::class => [
        'type' . TradeEnum::TYPE_BUY => '买单',
        'type' . TradeEnum::TYPE_SALE => '卖单',
        'status' . TradeEnum::STATUS_CREATE => '处理中',
        'status' . TradeEnum::STATUS_PART => '部分成交',
        'status' . TradeEnum::STATUS_FINISH => '成功',
        'status' . TradeEnum::STATUS_CANCEL => '取消',
        'buy_type' . TradeEnum::BUY_TYPE_AMOUNT => '按数量下单',
        'buy_type' . TradeEnum::BUY_TYPE_MONEY => '按金额下单',
    ],

    NftGenderEnum::class => [
        NftGenderEnum::NONE => '未知',
        NftGenderEnum::MALE => '雄兔',
        NftGenderEnum::FEMALE => '雌兔',
    ],

    NftMintStatusEnum::class => [
        NftMintStatusEnum::PROCESSING => '处理中',
        NftMintStatusEnum::SUCCESSFUL => '成功',
        NftMintStatusEnum::FAILURE => '失败',
    ],

    NftOrderStatusEnum::class => [
        NftOrderStatusEnum::PROCESSING => '处理中',
        NftOrderStatusEnum::SUCCESSFUL => '成功',
        NftOrderStatusEnum::FAILURE => '失败',
    ],

    NftTaskTypeEnum::class => [
        NftTaskTypeEnum::SIGN_IN => '每日签到',
    ],

    NftFertilityRewardTypeEnum::class => [
        NftFertilityRewardTypeEnum::CHILD => '子辈',
        NftFertilityRewardTypeEnum::GRANDSON => '孙辈',
    ],

    NftGroupRewardTypeEnum::class => [
        NftGroupRewardTypeEnum::MANAGER_HP_RESTORE => '进化奖',
        NftGroupRewardTypeEnum::OWNER_HP_RESTORE => '进化奖',
        NftGroupRewardTypeEnum::OWNER_MINT => 'Mint奖',
        NftGroupRewardTypeEnum::OWNER_MINT_RECOMMEND => 'Mint推荐奖',
    ],

    NftHpAddTypeEnum::class => [
        NftHpAddTypeEnum::INVITE_FRIEND_JOIN_NODE_GROUP_BUY => '邀请好友加入节点群购买',
    ],

    NftMintRewardTypeEnum::class => [
        NftMintRewardTypeEnum::CITY_NODE_RECOMMEND => '城市节点推荐',
        NftMintRewardTypeEnum::CITY_NODE => '城市节点',
        NftMintRewardTypeEnum::MARKET_ACCOUNT => '市场账户',
        NftMintRewardTypeEnum::SYSTEM_ACCOUNT => '系统账户',
        NftMintRewardTypeEnum::DESTRUCTION_ACCOUNT => '销毁账户',
    ],

    WalletOperateTypeEnum::class => [
        WalletOperateTypeEnum::INC => '添加',
        WalletOperateTypeEnum::DEC => '扣除',
    ],

    ImGroupTypeEnum::class => [
        ImGroupTypeEnum::NODE => '节点',
        ImGroupTypeEnum::NORMAL => '普通',
    ],

    ImGroupIdentityEnum::class => [
        ImGroupIdentityEnum::OWNER => '群主',
        ImGroupIdentityEnum::ADMINISTRATOR => '管理员',
        ImGroupIdentityEnum::NORMAL => '群成员',
    ],

    RedPacketStatusEnum::class => [
        RedPacketStatusEnum::ING => '领取中',
        RedPacketStatusEnum::COMPLETED => '领取完成',
        RedPacketStatusEnum::EXPIRED => '已过期',
    ],

    RedPacketTypeEnum::class => [
        RedPacketTypeEnum::FRIEND => '好友',
        RedPacketTypeEnum::GROUP_NORMAL => '固定',
        RedPacketTypeEnum::GROUP_RANDOM => '拼手气',
    ],

    RedPacketLedgerOperateEnum::class => [
        RedPacketLedgerOperateEnum::DISTRIBUTE => '发放',
        RedPacketLedgerOperateEnum::RECEIVE => '领取',
        RedPacketLedgerOperateEnum::REFUND => '退款',
    ],
];
