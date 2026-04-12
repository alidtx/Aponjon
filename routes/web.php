<?php

use App\Http\Controllers\Bid\BidController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\KycApprovalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Tasker\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('hh', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/marketplace', [HomeController::class, 'marketplace'])->name('marketplace');
Route::get('/category', [HomeController::class, 'category'])->name('category');
Route::get('/district-Wise-zila', [HomeController::class, 'districtWiseZila'])->name('district-Wise-zila');
Route::get('/Zila-Wise-upozila', [HomeController::class, 'ZilaWiseUpozila'])->name('Zila-Wise-upozila');

Route::get('/tasks/{taskId}/{slug}', [BidController::class, 'show'])->name('tasks.show');
Route::get('/show-bid-submit-form/{taskId}/{slug}', [BidController::class, 'showBidSubmissionForm'])->name('show.bid.submit.form');
Route::post('/bid-store', [BidController::class, 'bidStore'])->name('bid.store');


Route::middleware(['auth'])->group(function () {

    Route::middleware(['role:admin'])->group(function () {

        Route::get('admin', function () {
            return 'admin';
        });
    });
   Route::middleware(['profile_completed'])->group(function () {
    Route::middleware(['role:customer'])->group(function () {

        Route::prefix('customer')->name('customer.')->group(function () {
            Route::get('/dashboard', [CustomerController::class, 'index'])->name('dashboard');
            Route::get('/create-gig', [CustomerController::class, 'createGig'])->name('create.gig');
            Route::post('/gigs-store', [CustomerController::class, 'gigsStore'])->name('gigs.store');
        });
    });

    Route::middleware(['role:tasker'])->group(function () {
        
    Route::prefix('tasker')->name('tasker.')->group(function () {
        Route::get('/dashboard', [TaskController::class, 'index'])->name('dashboard');
        Route::get('/create-profile', [TaskController::class, 'createProfile'])->name('create.profile');
        Route::post('//store-profile', [TaskController::class, 'storeProfile'])->name('store.profile');
    });
});
});
Route::middleware('awaiting_kyc_approval')->get('/awaiting-kyc-approval', [KycApprovalController::class, 'index'])->name('kyc.awaiting-approval.index');

});




Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
