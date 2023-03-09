<?php

namespace App\Listeners;

use App\Enums\NftClassEnum;
use App\Enums\NftImageEnum;
use App\Enums\WalletEnum;
use App\Events\MemberCreatedEvent;
use App\Jobs\MemberCreatedJob;
use App\Models\NftImage;
use App\Models\Wallet;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MemberCreatedListener
{
    /**
     * Handle the event.
     *
     * @param MemberCreatedEvent $event
     * @return void
     */
    public function handle(MemberCreatedEvent $event)
    {
        $member = $event->getMember();

        // 钱包创建
        foreach (WalletEnum::getValues() as $type) {
            Wallet::firstOrCreate([
                'member_id' => $member->id,
                'coin_type' => $type,
            ]);
        }

        // 更新用户资料
        try {
            DB::transaction(function () use ($member) {
                $nftImage = NftImage::where('class', NftClassEnum::FREE)
                    ->where('status', NftImageEnum::STATUS_NOT_USE)
                    ->lockForUpdate()
                    ->firstOrFail();
                $nftImage->status = NftImageEnum::STATUS_USED;
                $nftImage->save();

                $member->default_avatar = $nftImage->uri;
                $member->avatar = $nftImage->uri;
                $member->nickname = Str::upper(Str::random(3));
                $member->lang = App::getLocale();
                $member->save();
            }, 3);
        } catch (Exception $exception) {
            Log::error('member created event', [
                'msg' => $exception->getMessage(),
                'trace' => $exception->getTrace(),
            ]);
        }

        if ($member->eventOnQueue) {
            MemberCreatedJob::dispatch($event->getMember());
        } else {
            MemberCreatedJob::dispatchSync($event->getMember());
        }
    }
}
