<?php

use App\Models\RedPacketLedger;

return [
    'yes' => '是',
    'difference' => '差额：',
    'min_transfer' => '最低转账额度 :amount',
    'transaction_cannot_mint' => ':no交易中无法Mint',
    'already_in_mint' => ':no赛博兔已在Mint中',
    'in_cooling_cannot_mint' => ':no处于冷却期无法Mint',
    'reached_mint_limit' => ':no已达Mint上限',

    'red_packet_ledger' . RedPacketLedger::OPERATE_RED_PACKET_DISTRIBUTE => '红包-发出群红包',
    'red_packet_ledger' . RedPacketLedger::OPERATE_RED_PACKET_RECEIVE => '红包-来自 :member',
    'red_packet_ledger' . RedPacketLedger::OPERATE_RED_PACKET_REFUND => '红包-退款',
    'red_packet_expired' => '该红包已超过24小时，如已领取，可在“红包记录”中查看。',
    'red_packet_done' => '红包已被领取完！',
];

