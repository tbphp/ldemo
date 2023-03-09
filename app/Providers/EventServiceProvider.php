<?php

namespace App\Providers;

use App\Events\AdminAssetEvent;
use App\Events\CheckNftTaskCompleteEvent;
use App\Events\ElectionPatriarchEvent;
use App\Events\MemberCreatedEvent;
use App\Events\NftHpRestoreEvent;
use App\Events\NftMintSuccessEvent;
use App\Events\NftOrderBuyNewEvent;
use App\Events\TradeCreatedEvent;
use App\Listeners\AdminAssetListener;
use App\Listeners\CheckNftTaskCompleteListener;
use App\Listeners\ElectionPatriarchListener;
use App\Listeners\MemberCreatedListener;
use App\Listeners\NftHpRestoreListener;
use App\Listeners\NftMintSuccessListener;
use App\Listeners\NftOrderBuyNewListener;
use App\Listeners\RecallPatriarchListener;
use App\Listeners\TradeCreatedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        MemberCreatedEvent::class => [
            MemberCreatedListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
