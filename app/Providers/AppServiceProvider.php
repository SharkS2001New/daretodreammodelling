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
        View::composer('*', function ($view) {
            $publicInfo = null;
            if (Auth::check()) {
                $publicInfo = UserPublicInfo::where('user_id', Auth::id())->first();
            }
            $view->with('publicInfo', $publicInfo);
        });

        View::composer('*', function ($view) {
            $path = public_path('meta.json');
            $meta = [];
        
            if (file_exists($path)) {
                $json = json_decode(file_get_contents($path), true);
        
                $uri = trim(request()->path(), '/');
                $uri = $uri === '' ? 'home' : $uri;
        
                $meta = $json[$uri] ?? [];
            }
        
            $view->with('meta', $meta);
        });  
    }
}
