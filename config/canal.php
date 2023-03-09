<?php

use App\Enums\CanalEventEnum;
use App\Jobs\ConfigurationUpdateCanalJob;
use App\Jobs\DailyStatisticsCanalJob;
use App\Jobs\MemberUpdateGradeCanalJob;
use App\Jobs\RedPacketOpenedCanalJob;
use App\Models\Asset;
use App\Models\Configuration;
use App\Models\ImGroup;
use App\Models\Member;
use App\Models\Nft;
use App\Models\NftFertilityRewardRecord;
use App\Models\NftGroupRewardRecord;
use App\Models\NftHpRestoreRecord;
use App\Models\NftMint;
use App\Models\NftOrder;
use App\Models\NftPatriarchCapitalInjectionRecord;
use App\Models\NftPatriarchRewardRecord;
use App\Models\NftTaskRewardRecord;
use App\Models\RedPacketDetail;
use App\Models\RedPacketLedger;
use App\Models\TradePendingFee;
use App\Models\Transaction;

$insert = CanalEventEnum::INSERT;
$update = CanalEventEnum::UPDATE;
$delete = CanalEventEnum::DELETE;

return [
    'server' => [
        'host' => env('CANAL_HOST', '127.0.0.1'),
        'port' => env('CANAL_PORT', 11111),
        'client' => env('CANAL_CLIENT', 1001),
        'destination' => env('CANAL_DESTINATION', ''),
        'max_times' => env('CANAL_MAX_TIME', 10000),
    ],
    'subscribes' => [
        MemberUpdateGradeCanalJob::class => [
            subscribe(Nft::class)->events($insert, $update)->columns('member_id'),
        ],
        ConfigurationUpdateCanalJob::class => [
            subscribe(Configuration::class)->events($update)->columns('*'),
        ],
        DailyStatisticsCanalJob::class => [
            subscribe(NftTaskRewardRecord::class)->events($insert)->queue('statistics')->delay(60),
            subscribe(NftFertilityRewardRecord::class)->events($insert)->queue('statistics')->delay(60),
            subscribe(NftPatriarchRewardRecord::class)->events($insert)->queue('statistics')->delay(60),
            subscribe(NftGroupRewardRecord::class)->events($insert)->queue('statistics')->delay(60),
            subscribe(NftPatriarchCapitalInjectionRecord::class)->events($insert)->queue('statistics')->delay(60),
            subscribe(Asset::class)->events($update)->columns('updated_at')->queue('statistics'),
            subscribe(TradePendingFee::class)->events($insert)->queue('statistics')->delay(60),
            subscribe(NftOrder::class)->events($update)->columns('updated_at')->queue('statistics')->delay(60),
            subscribe(NftHpRestoreRecord::class)->events($insert)->queue('statistics')->delay(60),
            subscribe(Nft::class)->events($insert)->queue('statistics')->delay(60),
            subscribe(NftMint::class)->events($update)->columns('updated_at')->queue('statistics')->delay(60),
            subscribe(Transaction::class)->events($update)->columns('deal_time')->columns('deal_time')->queue('statistics')->delay(60),
            subscribe(Member::class)->events($insert, $update)->columns('grade')->queue('statistics'),
            subscribe(ImGroup::class)->events($insert)->queue('statistics')->delay(60),
            subscribe(RedPacketLedger::class)->events($insert)->queue('statistics'),
        ],
        RedPacketOpenedCanalJob::class => [
            subscribe(RedPacketDetail::class)->events($update)->columns('receiver_id'),
        ],
    ],
];
