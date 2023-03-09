<?php

namespace App\Providers;

use App\Models\driver\MycatGrammar;
use App\Services\ApiPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // 兼容mycat
        $this->app->get('db.connection')->setSchemaGrammar(new MycatGrammar);
        $this->app->bind(LengthAwarePaginator::class, ApiPaginator::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 配置oss cdn域名
        if (config('filesystems.default') === 'oss' && config('filesystems.disks.oss.cdn_url')) {
            /** @noinspection PhpUndefinedMethodInspection */
            Storage::disk()->getAdapter()->setCdnUrl(config('filesystems.disks.oss.cdn_url'));
        }

        if (config('app.debug')) {
            DB::listen(function ($query) {
                Log::debug('sql', [
                    'sql' => $query->sql,
                    'bindings' => $query->bindings,
                    'time' => $query->time,
                ]);
            });
        }
    }
}
