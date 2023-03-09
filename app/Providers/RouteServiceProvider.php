<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('admin')
                ->prefix('admin')
                ->namespace($this->namespace)
                ->group(base_path('routes/admin.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        $limit = config('app.api_limit');

        RateLimiter::for('api', function (Request $request) use ($limit) {
            // 无限制
            if ($request->is(config('app.filter_urls.apilimit'))) {
                return Limit::none();
            }

            // 路径
            $path = $request->decodedPath();
            // 限制次数配置
            $limitNums = config('app.filter_urls.api_limit_nums');
            if (!empty($limitNums[$path])) {
                $limit = $limitNums[$path];
            }

            $limits = [Limit::perMinute($limit)->by($request->path() . '|' . $request->ip())];

            if (Auth::check() && Auth::id()) {
                $limits[] = Limit::perMinute($limit)->by($request->path() . '|' . Auth::id());
            }

            return $limits;
        });
    }
}
