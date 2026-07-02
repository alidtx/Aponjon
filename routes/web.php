<?php

use App\Http\Controllers\Bid\BidController;
use App\Http\Controllers\Bid\BidDisputedController;
use App\Http\Controllers\Payments\PaymentsController;
use App\Http\Controllers\Customer\CustomerBidController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\KycApprovalController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Customer\CustomerProfileController;
use App\Http\Controllers\Customer\CustomerProfileSettingController;
use App\Http\Controllers\Customer\GigController;
use App\Http\Controllers\Customer\CustomerChatController;
use App\Http\Controllers\Tasker\TaskerChatController;
use App\Http\Controllers\Tasker\TaskController;
use App\Http\Controllers\Tasker\TaskerBidController;
use App\Http\Controllers\Tasker\TaskerProfileController;
use App\Http\Controllers\Tasker\TaskerProfileSettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/marketplace', [HomeController::class, 'marketplace'])->name('marketplace');
Route::get('/category', [HomeController::class, 'category'])->name('category');

Route::get('/tasks/{taskId}/{slug}', [BidController::class, 'show'])->name('tasks.show');
Route::get('/show-bid-submit-form/{taskId}/{slug}', [BidController::class, 'showBidSubmissionForm'])->name('show.bid.submit.form');
Route::post('/bid-store', [BidController::class, 'bidStore'])->name('bid.store');

Route::prefix('tasker')->name('tasker.')->group(function () {
    Route::get('public-profile/{TaskerId}', [TaskerProfileController::class, 'TaskerPublicProfile'])->name('public.profile');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/awaiting-kyc-approval', [KycApprovalController::class, 'index'])
    ->name('kyc.awaiting-approval.index');

    Route::middleware(['role:admin'])->group(function () {
        Route::get('admin', fn() => 'admin');
    });

    Route::middleware(['ensure_user_approved'])->group(function () {
        Route::middleware(['role:customer'])->prefix('customer')->name('customer.')->group(function () {
            Route::get('/dashboard', [CustomerController::class, 'index'])->name('dashboard');
            Route::get('/customer-sidebar-info', [CustomerController::class, 'CustomerSidebarInfo'])->name('sidebar.info');
            Route::get('/customer-total-spend', [CustomerController::class, 'CustomerTotalSpend'])->name('total.spend');
            Route::get('/customer-success-rate', [CustomerController::class, 'CustomerSuccessRate'])->name('success.rate');
            Route::get('/bid-activity', [CustomerController::class, 'bidActivity'])->name('bid.activity');
            Route::get('/bid', [CustomerBidController::class, 'index'])->name('bids');
            Route::get('/disputed', [BidDisputedController::class, 'index'])->name('disputed');
            Route::get('/payment', [PaymentsController::class, 'index'])->name('payment');
            Route::post('customer/bids/{bid}/accept', [BidController::class, 'accept'])->name('bids.accept');
            Route::post('customer/bids/{bid}/cancel', [BidController::class, 'cancel'])->name('bids.cancel');
            Route::post('/customer/bids/dispute/{bid}', [BidController::class, 'dispute'])->name('bids.dispute');
            Route::get('/bids/waiting', [CustomerBidController::class, 'waitingForAcceptance'])->name('bids.waiting');
            Route::get('/bids/accepted', [CustomerBidController::class, 'accepted'])->name('bids.accepted');
            Route::get('/bids/in-progress', [CustomerBidController::class, 'inProgress'])->name('bids.in-progress');
            Route::get('/tasks/completed', [CustomerBidController::class, 'completed'])->name('tasks.completed');
            Route::get('/gig', [GigController::class, 'Index'])->name('gig');
            Route::get('/create-gig', [GigController::class, 'createGig'])->name('create.gig');
            Route::post('/gigs-store', [GigController::class, 'gigsStore'])->name('gigs.store');
            Route::get('/gigs-edit/{taskId}', [GigController::class, 'gigsEdit'])->name('gigs.edit');
            Route::post('/gigs-update/{taskId}', [GigController::class, 'gigsUpdate'])->name('gigs.update');
            Route::get('/edit-profile/{customerId}', [CustomerProfileController::class, 'editProfile'])->name('profile.edit');
            Route::post('/update-profile/{customerId}', [CustomerProfileController::class, 'updateProfile'])->name('profile.update');
            Route::get('/chats', [CustomerChatController::class, 'index'])->name('chats.index');
            Route::get('/chats/messages/{user}', [CustomerChatController::class, 'getMessages'])->name('chats.messages');
            Route::post('/chats/send', [CustomerChatController::class, 'send'])->name('chats.send');
            Route::post('/chats/mark-as-read/{user}', [CustomerChatController::class, 'markAsRead'])->name('chats.mark-as-read');
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
            Route::get('/applied-task', [TaskerBidController::class, 'index'])->name('applied.task');
            Route::get('/tasker-success-rate', [TaskController::class, 'TaskerSuccessRate'])->name('success.rate');
            Route::get('/pending-tasks', [TaskController::class, 'pendingTasks'])->name('pending.tasks');
            Route::get('/task-status', [TaskController::class, 'taskerTaskStatus'])->name('task.status');
            Route::get('/edit-profile/{taskerId}', [TaskerProfileController::class, 'editProfile'])->name('profile.edit');
            Route::post('/update-profile/{taskerId}', [TaskerProfileController::class, 'updateProfile'])->name('profile.update');
            Route::get('/chats', [TaskerChatController::class, 'index'])->name('chats.index');
            Route::get('/chats/messages/{user}', [TaskerChatController::class, 'getMessages'])->name('chats.messages');
            Route::post('/chats/send', [TaskerChatController::class, 'send'])->name('chats.send');
            Route::post('/chats/mark-as-read/{user}', [TaskerChatController::class, 'markAsRead'])->name('chats.mark-as-read'); 
            Route::get('/edit-tasker-profile-settings', [TaskerProfileSettingController::class, 'editSetting'])
            ->name('edit.tasker.profile.settings'); 
             Route::post('/update-tasker-profile-settings', [TaskerProfileSettingController::class, 'updateSetting'])
            ->name('update.tasker.profile.settings'); 
            Route::delete('/delete-tasker-account', [TaskerProfileSettingController::class, 'destroy'])
            ->name('delete.tasker.account'); 
        });
    });

   
     Route::middleware(['role:customer'])->prefix('customer')->name('customer.')->group(function () {
        Route::get('/create-profile', [CustomerProfileController::class, 'createProfile'])
        ->name('create.profile');
        Route::post('/store-profile', [CustomerProfileController::class, 'storeProfile'])->name('store.profile');
        
    });
    
    Route::middleware(['role:tasker'])->prefix('tasker')->name('tasker.')->group(function () {
        Route::get('/create-profile', [TaskerProfileController::class, 'createProfile'])
        ->name('create.profile');
        Route::post('/store-profile', [TaskerProfileController::class, 'storeProfile'])->name('store.profile');
    });
});

require __DIR__ . '/auth.php';
