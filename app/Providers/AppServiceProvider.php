<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\UserPublicInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // if (app()->environment('production')) {
        //     URL::forceScheme('https');
        // }
        
        View::composer('*', function ($view) {
            $publicInfo = null;
            if (Auth::check()) {
                $publicInfo = UserPublicInfo::where('user_id', Auth::id())->first();
            }
            $view->with('publicInfo', $publicInfo);
        });
    }
}
