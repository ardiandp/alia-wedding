<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PetaSitusController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TrackClickController;
use App\Http\Controllers\VenueController;
use App\Support\UrlRedirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/profil', [CompanyController::class, 'about'])->name('about');
Route::get('/tim-kami', [CompanyController::class, 'team'])->name('team');

Route::get('/venues', [VenueController::class, 'index'])->name('venues.index');
Route::get('/venues/{venue}', [VenueController::class, 'show'])->name('venues.show');

Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
Route::get('/packages/{package}', [PackageController::class, 'show'])->name('packages.show');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');

Route::get('/agenda', [EventController::class, 'index'])->name('events.index');
Route::get('/agenda/{event}', [EventController::class, 'show'])->name('events.show');

Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/kategori/{category}', [ArticleController::class, 'category'])->name('articles.category');
Route::get('/artikel/{article}', [ArticleController::class, 'show'])->name('articles.show');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/terima-kasih', [ContactController::class, 'thankyou'])->name('contact.thankyou');

/*
|--------------------------------------------------------------------------
| SEO Routes
|--------------------------------------------------------------------------
*/
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');
Route::get('/peta-situs', [PetaSitusController::class, 'index'])->name('peta-situs');

/*
|--------------------------------------------------------------------------
| Analytics
|--------------------------------------------------------------------------
*/
Route::post('/track/click', [TrackClickController::class, 'store'])
    ->middleware('throttle:30,1')
    ->name('track.click');

/*
|--------------------------------------------------------------------------
| Auth Routes (Breeze)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';

/*
|--------------------------------------------------------------------------
| Fallback: 301 Redirects From Changed Slugs
|--------------------------------------------------------------------------
|
| When an editor changes a title, the slug changes with it. This fallback
| catches the now-orphaned old URL and issues a permanent redirect so
| inbound links and search rankings survive.
|
*/
Route::fallback(function () {
    $redirect = UrlRedirect::resolveFor(request()->getRequestUri());

    if ($redirect === null) {
        abort(404);
    }

    return redirect()->to($redirect['to_path'], $redirect['status_code']);
});
