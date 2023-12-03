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
    Route::resource('service', \App\Http\Controllers\ServiceController::class)->except([
        'create', 'edit', 'show', 'update'
    ]);
    Route::get('service/{id}/get_service', [\App\Http\Controllers\ServiceController::class, 'getServiceById'])->name('service.info');
    Route::post('service/all', [\App\Http\Controllers\ServiceController::class, 'getAllServices'])->name('service.all');
    Route::post('service/{id}/update_service', [\App\Http\Controllers\ServiceController::class, 'updateService'])->name('service.update_service');

    // Service Request Controller
    Route::resource('service_request', \App\Http\Controllers\ServiceRequestController::class)->except([
        'create', 'edit', 'show', 'update'
    ]);
    Route::post('service_request/{id}/update_status', [\App\Http\Controllers\ServiceRequestController::class, 'updateStatus'])->name('service_request.update_status');
    Route::post('service_request/all', [\App\Http\Controllers\ServiceRequestController::class, 'getAllServiceRequests'])->name('service_request.all');

    // Event Controller
    Route::resource('event', \App\Http\Controllers\EventController::class)->except([
        'create', 'edit', 'show', 'update'
    ]);
    Route::post('event/{id}/update_event', [\App\Http\Controllers\EventController::class, 'updateStatus'])->name('event.update_event');
    Route::post('event/all', [\App\Http\Controllers\EventController::class, 'getAllEvents'])->name('event.all');

});
