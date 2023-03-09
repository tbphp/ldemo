<?php

use App\Models\RedPacketLedger;

return [
    'yes' => 'yes',
    'difference' => 'difference: ',
    'min_transfer' => 'Transfer minimum amount :amount',
    'transaction_cannot_mint' => ':no, The transaction cannot be mint',
    'already_in_mint' => ':no, The cyber bunny is already in mint',
    'in_cooling_cannot_mint' => ':no, Cannot Mint during cooling period',
    'reached_mint_limit' => ':no, The Mint limit has been reached',

    'red_packet_ledger' . RedPacketLedger::OPERATE_RED_PACKET_DISTRIBUTE => 'Red Packet-Send',
    'red_packet_ledger' . RedPacketLedger::OPERATE_RED_PACKET_RECEIVE => 'Red-From :member',
    'red_packet_ledger' . RedPacketLedger::OPERATE_RED_PACKET_REFUND => 'Red Packet-Refund',
    'red_packet_expired' => 'The red packet has been received for more than 24 hours. If you have already received it, you can check it in "Record of Red Packet".',
    'red_packet_done' => 'The red packet have been collected!',
];
