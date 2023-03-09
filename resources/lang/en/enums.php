<?php

use App\Enums\AppVersionTypeEnum;
use App\Enums\BscTxsEnum;
use App\Enums\ChainTypeEnum;
use App\Enums\ErrCodeEnum;
use App\Enums\LangEnum;
use App\Enums\NftClassEnum;
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
use App\Enums\WalletEnum;
use App\Enums\WalletOperateTypeEnum;

return [

    LangEnum::class => [
        LangEnum::EN => 'English',
        LangEnum::ZH_CN => '简体中文',
    ],

    ErrCodeEnum::class => [
        // ErrCodeEnum::UNAUTHORIZED => 'unauthorized',
        ErrCodeEnum::PASSWORD_EXPIRED => 'password expired',
        ErrCodeEnum::HTTP_AUTHORIZATION => 'http authorization',
        ErrCodeEnum::HTTP_NOT_FOUND => 'http not found',
        ErrCodeEnum::DATA_EMPTY => 'data empty',
        ErrCodeEnum::METHOD_NOT_ALLOWED => 'method not allowed',
        ErrCodeEnum::ILLEGAL_ERROR => 'illegal error',
        ErrCodeEnum::DATA_NOT_FOUND => 'data not found',
        ErrCodeEnum::VALIDATION_FAILED => 'validation failed',
        ErrCodeEnum::ERROR_DEFAULT => 'error',
        ErrCodeEnum::REQUEST_ERROR => 'request error',
    ],

    AppVersionTypeEnum::class => [
        AppVersionTypeEnum::ANDROID => 'Android',
        AppVersionTypeEnum::IOS => 'IOS',
    ],

    WalletEnum::class => [
        WalletEnum::TYPE_USDT => 'usdt',
        WalletEnum::TYPE_CC => 'cc',
        WalletEnum::TYPE_LINK => 'cl',
    ],

    ChainTypeEnum::class => [
        ChainTypeEnum::BSC => 'bsc',
        ChainTypeEnum::TRON => 'tron',
    ],

    BscTxsEnum::class => [
        'status' . BscTxsEnum::STATUS_CREATE => 'Processing',
        'status' . BscTxsEnum::STATUS_SUCCESS => 'Successful',
        'status' . BscTxsEnum::STATUS_FAIL => 'Failure',
    ],

    TransactionEnum::class => [
        'type' . TransactionEnum::TYPE_RECHARGE => 'Asset wallet transfer',
        'type' . TransactionEnum::TYPE_WITHDRAW => 'Asset wallet transfer out',
        'nft_type' . TransactionEnum::TYPE_RECHARGE => 'System wallet transfer',
        'nft_type' . TransactionEnum::TYPE_WITHDRAW => 'System wallet transfer out',
        'status' . TransactionEnum::STATUS_RECHARGE => 'Processing',
        'status' . TransactionEnum::STATUS_RECHARGE_CONFIRMATION => 'Successful',
        'status' . TransactionEnum::STATUS_RECHARGE_FAIL => 'Failure',
        'status' . TransactionEnum::STATUS_WITHDRAW_AUDIT => 'In the review',
        'status' . TransactionEnum::STATUS_WITHDRAWING => 'Processing',
        'status' . TransactionEnum::STATUS_WITHDRAW_FINISH => 'Successful',
        'status' . TransactionEnum::STATUS_WITHDRAW_FAIL => 'Failure',
        'asset_type' . TransactionEnum::ASSET_TYPE_TOKEN => 'Asset',
        'asset_type' . TransactionEnum::ASSET_TYPE_NFT => 'NFT',
    ],

    TradeEnum::class => [
        'type' . TradeEnum::TYPE_BUY => 'Buy',
        'type' . TradeEnum::TYPE_SALE => 'Sell',
        'status' . TradeEnum::STATUS_CREATE => 'Processing',
        'status' . TradeEnum::STATUS_PART => 'Part deal',
        'status' . TradeEnum::STATUS_FINISH => 'Successful',
        'status' . TradeEnum::STATUS_CANCEL => 'Cancel',
        'buy_type' . TradeEnum::BUY_TYPE_AMOUNT => 'Order by quantity',
        'buy_type' . TradeEnum::BUY_TYPE_MONEY => 'Order by money',
    ],

    NftClassEnum::class => [
        NftClassEnum::COMMON => 'Common',
        NftClassEnum::EPIC => 'Epic',
        NftClassEnum::LEGENDARY => 'Legendary',
        NftClassEnum::FREE => 'Free',
    ],

    NftGenderEnum::class => [
        NftGenderEnum::NONE => 'None',
        NftGenderEnum::MALE => 'male',
        NftGenderEnum::FEMALE => 'female',
    ],

    NftMintStatusEnum::class => [
        NftMintStatusEnum::PROCESSING => 'Processing',
        NftMintStatusEnum::SUCCESSFUL => 'Successful',
        NftMintStatusEnum::FAILURE => 'Failure',
    ],

    NftOrderStatusEnum::class => [
        NftOrderStatusEnum::PROCESSING => 'Processing',
        NftOrderStatusEnum::SUCCESSFUL => 'Successful',
        NftOrderStatusEnum::FAILURE => 'Failure',
    ],

    NftTaskTypeEnum::class => [
        NftTaskTypeEnum::SIGN_IN => 'Daily sign in',
    ],

    NftFertilityRewardTypeEnum::class => [
        NftFertilityRewardTypeEnum::CHILD => 'Child',
        NftFertilityRewardTypeEnum::GRANDSON => 'Grandson',
    ],

    NftGroupRewardTypeEnum::class => [
        NftGroupRewardTypeEnum::MANAGER_HP_RESTORE => 'Evolution Reward',
        NftGroupRewardTypeEnum::OWNER_HP_RESTORE => 'Evolution Reward',
        NftGroupRewardTypeEnum::OWNER_MINT => 'Mint Reward',
        NftGroupRewardTypeEnum::OWNER_MINT_RECOMMEND => 'Referral Reward',
    ],

    NftHpAddTypeEnum::class => [
        NftHpAddTypeEnum::INVITE_FRIEND_JOIN_NODE_GROUP_BUY => 'Invite friend join node group buy',
    ],

    NftMintRewardTypeEnum::class => [
        NftMintRewardTypeEnum::CITY_NODE_RECOMMEND => 'City node recommend',
        NftMintRewardTypeEnum::CITY_NODE => 'City node',
        NftMintRewardTypeEnum::MARKET_ACCOUNT => 'Market account',
        NftMintRewardTypeEnum::SYSTEM_ACCOUNT => 'System account',
        NftMintRewardTypeEnum::DESTRUCTION_ACCOUNT => 'Destruction account',
    ],

    WalletOperateTypeEnum::class => [
        WalletOperateTypeEnum::INC => 'Add',
        WalletOperateTypeEnum::DEC => 'Deduct',
    ],

    RedPacketStatusEnum::class => [
        RedPacketStatusEnum::ING => 'Ing',
        RedPacketStatusEnum::COMPLETED => 'Completed',
        RedPacketStatusEnum::EXPIRED => 'Expired',
    ],

    RedPacketTypeEnum::class => [
        RedPacketTypeEnum::FRIEND => 'Friend',
        RedPacketTypeEnum::GROUP_NORMAL => 'Fixed',
        RedPacketTypeEnum::GROUP_RANDOM => 'Spell luck',
    ],

    RedPacketLedgerOperateEnum::class => [
        RedPacketLedgerOperateEnum::DISTRIBUTE => 'Distribute',
        RedPacketLedgerOperateEnum::RECEIVE => 'Receive',
        RedPacketLedgerOperateEnum::REFUND => 'Refund',
    ],
];
