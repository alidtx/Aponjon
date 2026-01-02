<?php

use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\HomeController;
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
Route::get('marketplace', [HomeController::class, 'marketplace'])->name('marketplace');
Route::patch('fetchTaskCardData', [HomeController::class, 'FetchTasks'])->name('fetch-task-data');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('admin', function(){
        return 'admin';
    });
});

Route::middleware(['auth', 'role:customer','verified'])->group(function () {

    Route::prefix('customer')->name('customer.')->group(function () {
        Route::get('dashboard', [CustomerController::class, 'index'])->name('dashboard');
        Route::get('create-gig', [CustomerController::class, 'createGig'])->name('create.gig');
        Route::post('gigs-store', [CustomerController::class, 'gigsStore'])->name('gigs.store');
    }); 

});

Route::middleware(['auth', 'role:tasker','verified'])->group(function () {
    Route::get('tasker', function(){
        return 'tasker';
    });
});




Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
