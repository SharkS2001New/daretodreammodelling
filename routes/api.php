<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoLikeController;
use App\Http\Controllers\VideoLikeController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// Video
Route::post('/videos/{video}/like', [VideoLikeController::class, 'store'])->name('videos.like');
Route::delete('/videos/{video}/like', [VideoLikeController::class, 'destroy'])->name('videos.unlike');
Route::post('/videos/{video}/view', [VideoViewController::class, 'store'])->name('videos.view');