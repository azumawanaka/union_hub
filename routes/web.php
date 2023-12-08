<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();

Route::get('client/search', [\App\Http\Controllers\ClientController::class, 'search'])->name('client.search');

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Service Controller
    Route::resource('services', \App\Http\Controllers\ServiceController::class)->except([
        'create', 'edit', 'show', 'update'
    ]);
    Route::get('services/{id}/get_service', [\App\Http\Controllers\ServiceController::class, 'getServiceById'])->name('services.info');
    Route::post('services/all', [\App\Http\Controllers\ServiceController::class, 'getAllServices'])->name('services.all');
    Route::post('services/{id}/update_service', [\App\Http\Controllers\ServiceController::class, 'updateService'])->name('services.update_service');

    // Service Request Controller
    Route::resource('service_requests', \App\Http\Controllers\ServiceRequestController::class)->except([
        'create', 'edit', 'show', 'update'
    ]);
    Route::post('service_requests/{id}/update_status', [\App\Http\Controllers\ServiceRequestController::class, 'updateStatus'])->name('service_requests.update_status');
    Route::post('service_requests/all', [\App\Http\Controllers\ServiceRequestController::class, 'getAllServiceRequests'])->name('service_requests.all');

    // Event Controller
    Route::resource('events', \App\Http\Controllers\EventController::class)->except([
        'create', 'edit', 'update'
    ]);
    Route::post('events/{id}/update_event', [\App\Http\Controllers\EventController::class, 'updateEvent'])->name('events.update_event');
    Route::post('events/all', [\App\Http\Controllers\EventController::class, 'getAllEvents'])->name('events.all');
});
