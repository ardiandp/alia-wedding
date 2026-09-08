<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\HomepageController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\MediaLibraryController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\VenueController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'staff'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Staff-accessible CRM
    Route::get('leads', [LeadController::class, 'index'])->name('leads.index');
    Route::get('leads/{lead}', [LeadController::class, 'show'])->name('leads.show');
    Route::patch('leads/{lead}/status', [LeadController::class, 'updateStatus'])->name('leads.status');
    Route::patch('leads/{lead}/assign', [LeadController::class, 'assign'])->name('leads.assign');
    Route::post('leads/{lead}/notes', [LeadController::class, 'storeNote'])->name('leads.notes.store');
    Route::post('leads/{lead}/consultations', [LeadController::class, 'storeConsultation'])->name('leads.consultations.store');

    // Content management (admin only)
    Route::middleware('admin')->group(function () {
        Route::get('media', [MediaLibraryController::class, 'index'])->name('media.index');
        Route::get('media/browser', [MediaLibraryController::class, 'browser'])->name('media.browser');
        Route::post('media', [MediaLibraryController::class, 'store'])->name('media.store');
        Route::delete('media/{media}', [MediaLibraryController::class, 'destroy'])->name('media.destroy');

        Route::resource('venues', VenueController::class)->except(['show']);
        Route::post('venues/{venue}/images', [VenueController::class, 'storeImage'])->name('venues.images.store');
        Route::delete('venues/images/{image}', [VenueController::class, 'destroyImage'])->name('venues.images.destroy');
        Route::post('venues/{venue}/facilities', [VenueController::class, 'storeFacility'])->name('venues.facilities.store');
        Route::delete('venues/facilities/{facility}', [VenueController::class, 'destroyFacility'])->name('venues.facilities.destroy');

        Route::resource('packages', PackageController::class)->except(['show']);
        Route::post('packages/{package}/items', [PackageController::class, 'storeItem'])->name('packages.items.store');
        Route::delete('packages/items/{item}', [PackageController::class, 'destroyItem'])->name('packages.items.destroy');

        Route::resource('events', EventController::class)->except(['show']);
        Route::resource('articles', ArticleController::class)->except(['show']);
        Route::resource('galleries', GalleryController::class)->except(['show']);
        Route::resource('testimonials', TestimonialController::class)->except(['show']);
        Route::resource('teams', TeamController::class)->except(['show']);
        Route::resource('services', ServiceController::class)->except(['show']);

        Route::get('about', [AboutController::class, 'edit'])->name('about.edit');
        Route::put('about', [AboutController::class, 'update'])->name('about.update');

        Route::get('homepage', [HomepageController::class, 'edit'])->name('homepage.edit');
        Route::put('homepage', [HomepageController::class, 'update'])->name('homepage.update');

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });
});
