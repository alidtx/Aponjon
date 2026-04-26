<?php

use App\Http\Controllers\Bid\BidController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\KycApprovalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Tasker\TaskController;
use App\Http\Controllers\Tasker\TaskerProfileController;
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

Route::get('/tasks/{taskId}/{slug}', [BidController::class, 'show'])->name('tasks.show');
Route::get('/show-bid-submit-form/{taskId}/{slug}', [BidController::class, 'showBidSubmissionForm'])->name('show.bid.submit.form');
Route::post('/bid-store', [BidController::class, 'bidStore'])->name('bid.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('awaiting_kyc_approval')->get('/awaiting-kyc-approval', [KycApprovalController::class, 'index'])
    ->name('kyc.awaiting-approval.index');

    Route::middleware(['role:admin'])->group(function () {
        Route::get('admin', fn() => 'admin');
    });

    Route::middleware(['ensure_user_approved'])->group(function () {
        Route::middleware(['role:customer'])->prefix('customer')->name('customer.')->group(function () {
            Route::get('/dashboard', [CustomerController::class, 'index'])->name('dashboard');
            Route::get('/create-gig', [CustomerController::class, 'createGig'])->name('create.gig');
            Route::post('/gigs-store', [CustomerController::class, 'gigsStore'])->name('gigs.store');
           
        });

        Route::middleware(['role:tasker'])->prefix('tasker')->name('tasker.')->group(function () {
            Route::get('/dashboard', [TaskController::class, 'index'])->name('dashboard');
            Route::get('/tasker-sidebar-info', [TaskController::class, 'taskerSidebarInfo'])->name('sidebar.info');
            Route::get('/tasker-sidebar-success-rate', [TaskController::class, 'taskerSidebarSuccessRate'])->name('sidebar.success.rate');
            Route::get('/tasker-total-earning', [TaskController::class, 'TaskerTotalEarning'])->name('total.earning');
            Route::get('/tasker-success-rate', [TaskController::class, 'TaskerSuccessRate'])->name('success.rate');
            Route::get('/pending-tasks', [TaskController::class, 'pendingTasks'])->name('pending.tasks');
            Route::get('/assigned-tasks', [TaskController::class, 'AssignedTask'])->name('assigned.tasks');
            Route::get('/edit-profile/{taskerId}', [TaskerProfileController::class, 'editProfile'])->name('profile.edit');
            Route::post('/update-profile/{taskerId}', [TaskerProfileController::class, 'updateProfile'])->name('profile.update');
        });
    });

   
     Route::middleware(['role:customer'])->prefix('customer')->name('customer.')->group(function () {
        Route::get('/create-profile', [CustomerController::class, 'createProfile'])
        ->name('create.profile')
         ->name('create.profile')->middleware('awaiting_kyc_approval');
        Route::post('/store-profile', [CustomerController::class, 'storeProfile'])->name('store.profile');
        
    });
    
    Route::middleware(['role:tasker'])->prefix('tasker')->name('tasker.')->group(function () {
        Route::get('/create-profile', [TaskerProfileController::class, 'createProfile'])
        ->name('create.profile')->middleware('awaiting_kyc_approval');
        Route::post('/store-profile', [TaskerProfileController::class, 'storeProfile'])->name('store.profile');
    });
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
