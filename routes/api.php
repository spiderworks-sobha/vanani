<?php

use App\Http\Controllers\Apis\GalleryController;
use App\Http\Controllers\Apis\AccommodationController;
use App\Http\Controllers\Apis\ActivityController;
use App\Http\Controllers\Apis\AmenityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apis\BlogController;
use App\Http\Controllers\Apis\AuthController;
use App\Http\Controllers\Apis\AwardController;
use App\Http\Controllers\Apis\CommonController;
use App\Http\Controllers\Apis\MenuController;
use App\Http\Controllers\Apis\PackageController;
use App\Http\Controllers\Apis\PartnerController;
use App\Http\Controllers\Apis\ProductController;
use App\Http\Controllers\Apis\TeamController;
use App\Http\Controllers\Apis\TestimonialController;
use App\Http\Controllers\Apis\RentalController;
use App\Http\Controllers\Apis\SustainableTourismController;

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
Route::get('blogs/category-listing', [BlogController::class, 'category_listing'])->name('api.blogs.category-listing');
Route::get('blogs/{slug}', [BlogController::class, 'view'])->name('api.blogs.view');

Route::get('settings', [CommonController::class, 'settings'])->name('settings');
Route::get('sliders/{slider_name?}', [CommonController::class, 'sliders'])->name('sliders');
Route::get('home/what-we-offer', [CommonController::class, 'home_what_we_offer'])->name('home.what-we-offer');

Route::get('products/about-us', [ProductController::class, 'about_us'])->name('api.products.about-us');
Route::get('products/featured', [ProductController::class, 'featured'])->name('api.products.featured');
Route::get('products/home-bottom', [ProductController::class, 'home_bottom'])->name('api.products.home-bottom');

Route::get('testimonials', [TestimonialController::class, 'index'])->name('api.testimonials.index');

Route::get('members', [TeamController::class, 'index'])->name('api.members.index');

Route::get('partners', [PartnerController::class, 'index'])->name('api.partners.index');
Route::get('partners/featured', [PartnerController::class, 'featured'])->name('api.partners.featured');

Route::get('awards', [AwardController::class, 'index'])->name('api.partners.index');
Route::get('awards/latest', [AwardController::class, 'latest'])->name('api.partners.latest');

Route::get('page/{slug}', [CommonController::class, 'page'])->name('api.page');
Route::get('widget/{code}', [CommonController::class, 'widget'])->name('api.widget');
Route::get('menu/header', [MenuController::class, 'header'])->name('api.menu.header');
Route::get('menu/{menu_position}', [MenuController::class, 'index'])->name('api.menu');
Route::get('company-pages/{slug}', [CommonController::class, 'company_pages'])->name('api.company-pages');

Route::get('tags', [CommonController::class, 'tags'])->name('api.tags');
Route::get('countries', [CommonController::class, 'countries'])->name('api.countries');

Route::get('rentals', [RentalController::class, 'index'])->name('rentals.index');
Route::get('rentals/featured', [RentalController::class, 'featured'])->name('rentals.featured');
Route::get('rentals/reviews', [RentalController::class, 'reviews'])->name('rentals.reviews');
Route::get('rentals/{slug}', [RentalController::class, 'details'])->name('rentals.details');

Route::get('accommodations', [AccommodationController::class, 'index'])->name('accommodations.index');
Route::get('accommodations/featured', [AccommodationController::class, 'featured'])->name('accommodations.featured');
Route::get('accommodations/reviews', [AccommodationController::class, 'reviews'])->name('accommodations.reviews');
Route::get('accommodations/{slug}', [AccommodationController::class, 'details'])->name('accommodations.details');

Route::get('packages', [PackageController::class, 'index'])->name('packages.index');
Route::get('packages/reviews', [PackageController::class, 'reviews'])->name('packages.reviews');
Route::get('packages/{slug}', [PackageController::class, 'details'])->name('packages.details');
Route::post('custom-package/save', [PackageController::class, 'custom_package_save'])->name('packages.custom-package.save');

Route::get('gallery', [GalleryController::class, 'index'])->name('api.gallery.index');
Route::get('gallery/{slug}', [GalleryController::class, 'view'])->name('api.gallery.view');
Route::get('gallery/medias/{slug}', [GalleryController::class, 'medias'])->name('api.gallery.medias');

Route::get('sustainable-tourism', [SustainableTourismController::class, 'index'])->name('api.sustainable-tourism.index');
Route::get('sustainable-tourism/{slug}', [SustainableTourismController::class, 'view'])->name('api.sustainable-tourism.view');

Route::get('reviews', [TestimonialController::class, 'index'])->name('api.testimonials.index');
Route::get('reviews/featured', [TestimonialController::class, 'featured'])->name('api.testimonials.featured');
Route::get('reviews/videos', [TestimonialController::class, 'videos'])->name('api.testimonials.videos');
Route::get('reviews/texts', [TestimonialController::class, 'texts'])->name('api.testimonialss.texts');

Route::get('activities', [ActivityController::class, 'index'])->name('api.activities.index');
Route::get('activities/featured', [ActivityController::class, 'featured'])->name('api.activities.featured');

Route::get('amenities', [AmenityController::class, 'index'])->name('api.amenities.index');
Route::get('amenities/featured', [AmenityController::class, 'featured'])->name('api.amenities.featured');

Route::post('contact/save', [CommonController::class, 'contact_save'])->name('contacts.save');

Route::get('coupons', [CommonController::class, 'coupons'])->name('coupons');

