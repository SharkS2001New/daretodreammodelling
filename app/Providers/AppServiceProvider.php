<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
     * Append the file's last-modified time to a public asset URL so browsers
     * pick up changes instead of replaying a cached copy. Falls back to the
     * plain URL when the file is missing (e.g. a CDN path).
     */
    public static function versionedAsset(string $path): string
    {
        $url = asset($path);
        $file = public_path($path);

        if (! is_file($file)) {
            return $url;
        }

        return $url . (str_contains($url, '?') ? '&' : '?') . 'v=' . filemtime($file);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // @assetv('css/theme.css') -> /css/theme.css?v=<file mtime>
        // Browsers cache these files aggressively (Apache sends no Cache-Control),
        // so the stamp makes a deploy serve the new file instead of a stale copy.
        Blade::directive('assetv', function ($expression) {
            return "<?php echo \App\Providers\AppServiceProvider::versionedAsset({$expression}); ?>";
        });

        View::composer('*', function ($view) {
            $authPublicInfo = null;
            if (Auth::check()) {
                $authPublicInfo = UserPublicInfo::where('user_id', Auth::id())->first();
            }
            $view->with('authPublicInfo', $authPublicInfo);
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
