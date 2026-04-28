<?php

use App\Http\Controllers\Bid\BidController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\KycApprovalController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Customer\CustomerProfileController;
use App\Http\Controllers\Customer\CustomerProfileSettingController;
use App\Http\Controllers\Tasker\TaskController;
use App\Http\Controllers\Tasker\TaskerProfileController;
use App\Http\Controllers\Tasker\TaskerProfileSettingController;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/marketplace', [HomeController::class, 'marketplace'])->name('marketplace');
Route::get('/category', [HomeController::class, 'category'])->name('category');

Route::get('/tasks/{taskId}/{slug}', [BidController::class, 'show'])->name('tasks.show');
Route::get('/show-bid-submit-form/{taskId}/{slug}', [BidController::class, 'showBidSubmissionForm'])->name('show.bid.submit.form');
Route::post('/bid-store', [BidController::class, 'bidStore'])->name('bid.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/awaiting-kyc-approval', [KycApprovalController::class, 'index'])
    ->name('kyc.awaiting-approval.index');

    Route::middleware(['role:admin'])->group(function () {
        Route::get('admin', fn() => 'admin');
    });

    Route::middleware(['ensure_user_approved'])->group(function () {
        Route::middleware(['role:customer'])->prefix('customer')->name('customer.')->group(function () {
            Route::get('/dashboard', [CustomerController::class, 'index'])->name('dashboard');
            Route::get('/tasker-sidebar-info', [CustomerController::class, 'CustomerSidebarInfo'])->name('sidebar.info');
            Route::get('/create-gig', [CustomerController::class, 'createGig'])->name('create.gig');
            Route::post('/gigs-store', [CustomerController::class, 'gigsStore'])->name('gigs.store');
            Route::get('/edit-profile/{customerId}', [CustomerProfileController::class, 'editProfile'])->name('profile.edit');
            Route::post('/update-profile/{customerId}', [CustomerProfileController::class, 'updateProfile'])->name('profile.update'); 
            Route::get('/edit-customer-profile-settings', [CustomerProfileSettingController::class, 'editSetting'])
            ->name('edit.customer.profile.settings'); 
             Route::post('/update-customer-profile-settings', [CustomerProfileSettingController::class, 'updateSetting'])
            ->name('update.customer.profile.settings'); 
            Route::delete('/delete-customer-account', [CustomerProfileSettingController::class, 'destroy'])
            ->name('delete.customer.account'); 
           
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
            Route::get('/edit-tasker-profile-settings', [TaskerProfileSettingController::class, 'editSetting'])
            ->name('edit.tasker.profile.settings'); 
             Route::post('/update-tasker-profile-settings', [TaskerProfileSettingController::class, 'updateSetting'])
            ->name('update.tasker.profile.settings'); 
            Route::delete('/delete-tasker-account', [TaskerProfileSettingController::class, 'destroy'])
            ->name('delete.tasker.account'); 
        });
    });

   
     Route::middleware(['role:customer'])->prefix('customer')->name('customer.')->group(function () {
        Route::get('/create-profile', [CustomerController::class, 'createProfile'])
        ->name('create.profile');
        Route::post('/store-profile', [CustomerController::class, 'storeProfile'])->name('store.profile');
        
    });
    
    Route::middleware(['role:tasker'])->prefix('tasker')->name('tasker.')->group(function () {
        Route::get('/create-profile', [TaskerProfileController::class, 'createProfile'])
        ->name('create.profile');
        Route::post('/store-profile', [TaskerProfileController::class, 'storeProfile'])->name('store.profile');
    });
});

require __DIR__ . '/auth.php';
