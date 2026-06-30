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
            $uri = trim(request()->path(), '/');
            $uri = $uri === '' ? 'home' : $uri;

            $defaults = config('page-meta.pages.' . $uri, []);
            $overrides = [];

            if (file_exists($path)) {
                $json = json_decode(file_get_contents($path), true) ?? [];
                $overrides = $json[$uri] ?? [];
            }

            $meta = array_merge($defaults, array_filter($overrides, fn ($value) => $value !== null && $value !== ''));

            $suffix = config('page-meta.title_suffix', 'Dare to Dream Modelling');
            $documentTitle = $meta['title'] ?? $suffix;

            if ($uri !== 'home' && ! str_contains(strtolower($documentTitle), 'dare to dream')) {
                $documentTitle = $documentTitle . ' | ' . $suffix;
            }

            $view->with([
                'meta' => $meta,
                'documentTitle' => $documentTitle,
                'pageHeading' => $meta['heading'] ?? null,
                'pageSubtitle' => $meta['subtitle'] ?? null,
            ]);
        });
    }
}
