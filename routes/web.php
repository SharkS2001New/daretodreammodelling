<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\MetaController;
use App\Http\Controllers\TestimonialsController;
use App\Http\Controllers\BlogController; 
use App\Http\Controllers\BlogsCategoryController;
use App\Http\Controllers\Account\PublicInfoController;
use App\Http\Controllers\Account\LinkedAccountsController;
use App\Http\Controllers\Account\TikTokController;
use Illuminate\Support\Str;
use App\Http\Controllers\ModelUploadsController;
use App\Http\Controllers\PhotoViewController;
use App\Http\Controllers\PhotoLikeController;
use App\Http\Controllers\VideoLikeController;
use App\Http\Controllers\VideoViewController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\ModelsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomepageController::class, 'index']);
Route::get('/about-us', [HomepageController::class, 'about'])->name('about-us');
Route::get('/contact-us', [HomepageController::class, 'contact'])->name('contact-us');
Route::get('/faq', [HomepageController::class, 'faq'])->name('faq');
Route::get('/testimonials', [TestimonialsController::class, 'index'])->name('testimonials');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index'); // list
Route::get('/privacy-policy', [HomepageController::class, 'privacy'])->name('privacy-policy');
Route::get('/terms-of-use', [HomepageController::class, 'terms'])->name('terms-of-use');
Route::get('/modelling-advice', [HomepageController::class, 'Advice'])->name('modelling-advice');
Route::get('/how-it-works', [HomepageController::class, 'HowItWorks'])->name('how-it-works');

Route::get('/models', [ModelsController::class, 'index'])->name('models.index');
// Route::post('/model/{id}/view', [ModelsController::class, 'viewPhoto'])->name('models.view');
Route::get('/model/{id}/details', [ModelsController::class, 'details']);

// Likes
Route::post('/model/{id}/like', [PhotoLikeController::class, 'store'])->name('photos.like');
Route::delete('/model/{id}/like', [PhotoLikeController::class, 'destroy'])->name('photos.unlike');

// Views
Route::post('/model/{id}/view', [PhotoViewController::class, 'store'])->name('photos.view');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/console', function () {
        return view('console');
    })->name('console');
});

Route::middleware('auth')->group(function () {
    Route::get('/account', [HomepageController::class, 'Account']);

    Route::get('/account/public', [PublicInfoController::class, 'edit'])->name('account.public.edit');
    Route::post('/account/public', [PublicInfoController::class, 'update'])->name('account.public.update');
    Route::post('/account/public/profile-picture', [PublicInfoController::class, 'updateProfilePicture'])->name('account.public.updateProfilePicture');
    
    Route::get('/account/personal', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/account/linked', [LinkedAccountsController::class, 'index'])->name('account.linked');
    Route::post('/account/linked', [LinkedAccountsController::class, 'update'])->name('account.linked.update');

    Route::get('/account/tiktok/redirect', [TikTokController::class, 'redirect'])->name('tiktok.connect');
    Route::get('/account/tiktok/callback', [TikTokController::class, 'callback'])->name('tiktok.callback');
    Route::post('/account/tiktok/disconnect', [TikTokController::class, 'disconnect'])->name('tiktok.disconnect');
    Route::get('/account/tiktok/reconnect', [TikTokController::class, 'reconnect'])->name('tiktok.reconnect');
    Route::get('/account/tiktok/videos', [TikTokController::class, 'videos'])->name('tiktok.videos');
    Route::get('/account/tiktok/status', [TikTokController::class, 'status'])->name('tiktok.status');

    Route::post('/model/photos/upload', [ModelUploadsController::class, 'uploadPhoto'])->name('model.photos.upload');
    Route::delete('/model/photos/{id}', [ModelUploadsController::class, 'deletePhoto'])->name('model.photos.delete');

    Route::post('/model/videos/upload', [ModelUploadsController::class, 'uploadVideo'])->name('model.videos.upload');
    Route::delete('/model/videos/{id}', [ModelUploadsController::class, 'deleteVideo'])->name('model.videos.delete');
    Route::post('/model/videos/store-link', [ModelUploadsController::class, 'storeLink'])->name('model.videos.storeLink');

    // Followers
    Route::post('/models/{model}/follow', [FollowerController::class, 'store'])->name('models.follow');
    Route::delete('/models/{model}/follow', [FollowerController::class, 'destroy'])->name('models.unfollow');

    Route::get('/testimonials/create', [TestimonialsController::class, 'create'])->name('testimonials.create');
    Route::get('/testimonials/{id}/edit', [TestimonialsController::class, 'edit'])->name('testimonials.edit');
    Route::post('/testimonials', [TestimonialsController::class, 'store'])->name('testimonials.store'); 
    Route::put('/testimonials/{id}', [TestimonialsController::class, 'update'])->name('testimonials.update');
    Route::delete('/testimonials/{id}', [TestimonialsController::class, 'destroy'])->name('testimonials.destroy');
    Route::post('/testimonials/upload-image', [TestimonialsController::class, 'uploadImage'])->name('testimonials.upload');  

    Route::get('/blog/create', [BlogController::class, 'create'])->name('blogs.create'); // create form
    Route::post('/blog', [BlogController::class, 'store'])->name('blogs.store'); // save new blog
    Route::get('/blog/{id}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
    Route::put('/blog/{id}', [BlogController::class, 'update'])->name('blogs.update');
    Route::delete('/blog/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy'); // delete blog
    Route::post('/blogs/upload-image', [BlogController::class, 'uploadImage'])->name('blogs.uploadImage');

    Route::resource('blogs-categories', BlogsCategoryController::class);

    Route::get('/seo-metas', [MetaController::class, 'index'])->name('seo-metas.index');
    Route::get('seo-metas/create', [MetaController::class, 'create'])->name('seo-metas.create');
    Route::post('seo-metas/store', [MetaController::class, 'store'])->name('seo-metas.store');
    Route::get('/seo-metas/{page}/edit', [MetaController::class, 'edit'])->name('seo-metas.edit');
    Route::post('/seo-metas/{page}', [MetaController::class, 'update'])->name('seo-metas.update');
    Route::delete('/seo-metas/{page}', [MetaController::class, 'destroy'])->name('seo-metas.destroy');
});

Route::get('/model/{slug}', [ModelUploadsController::class, 'index'])->name('models.show');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blogs.show'); // show single blog 

//Clear Cache in laravel app
Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    return redirect('/console')->with('success', 'Cache cleared successfully!');
});

require __DIR__.'/auth.php';
