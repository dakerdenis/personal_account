<?php

namespace App\Providers;

use App\Http\Middleware\RestrictIpMiddleware;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Traits\LoadsTranslatedCachedRoutes;

class RouteServiceProvider extends ServiceProvider
{

    use LoadsTranslatedCachedRoutes;

    public const HOME = '/backend/a5t465grp/dashboard';

    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::prefix('backend/a5t465grp')->middleware(['web', RestrictIpMiddleware::class])
                ->name('backend.')
                ->namespace($this->namespace)
                ->group(base_path('routes/backend.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
