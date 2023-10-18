<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apis\BlogController;
use App\Http\Controllers\Apis\AuthController;
use App\Http\Controllers\Apis\CommonController;
use App\Http\Controllers\Apis\MenuController;
use App\Http\Controllers\Apis\ProductController;
use App\Http\Controllers\Apis\TestimonialController;

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

Route::post('login', [AuthController::class, 'login'])->name('app.login');
Route::post('verify-otp', [AuthController::class, 'verify_otp'])->name('app.verify-otp');

Route::get('blogs', [BlogController::class, 'index'])->name('api.blogs.index');
Route::get('blogs/categories', [BlogController::class, 'categories'])->name('api.blogs.categories');
Route::get('blogs/featured', [BlogController::class, 'featured'])->name('api.blogs.featured');
Route::get('blogs/{slug}', [BlogController::class, 'view'])->name('api.blogs.view');

Route::get('settings', [CommonController::class, 'settings'])->name('settings');
Route::get('sliders', [CommonController::class, 'sliders'])->name('sliders');

Route::get('products/about-us', [ProductController::class, 'about_us'])->name('api.products.about-us');
Route::get('products/featured', [ProductController::class, 'featured'])->name('api.products.featured');

Route::get('testimonials/featured', [TestimonialController::class, 'featured'])->name('api.testimonials.featured');

Route::get('page/{slug}', [CommonController::class, 'page'])->name('api.page');
Route::get('widget/{code}', [CommonController::class, 'widget'])->name('api.widget');
Route::get('menu/{menu_position}', [MenuController::class, 'index'])->name('api.menu');
