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

Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', \App\Http\Controllers\UserController::class)->except([
        'create', 'update'
    ]);

    Route::get('client/search', [\App\Http\Controllers\ClientController::class, 'search'])->name('client.search');
    Route::post('/upload-photo', [\App\Http\Controllers\UserController::class, 'uploadProfilePhoto'])->name('upload.profile-photo');
    Route::put('users/{id}/update_user', [\App\Http\Controllers\UserController::class, 'updateUser'])->name('users.update_user');
    Route::post('users/{id}/update_password', [\App\Http\Controllers\UserController::class, 'updatePassword'])->name('users.update_password');
    Route::post('/check-old-password', [\App\Http\Controllers\UserController::class, 'checkOldPassword'])->name('users.check_old_password');

    Route::resource('events', \App\Http\Controllers\EventController::class)->except([
        'create', 'edit', 'update'
    ]);
    Route::post('events/{id}/update_event', [\App\Http\Controllers\EventController::class, 'updateEvent'])->name('events.update_event');
    Route::post('events/all', [\App\Http\Controllers\EventController::class, 'getAllEvents'])->name('events.all');
    Route::get('events/all/json_type', [\App\Http\Controllers\EventController::class, 'getJsonTypeEvents'])->name('events.json_type_events');

    Route::get('event-calendar', [\App\Http\Controllers\CalendarController::class, 'index'])->name('event-calendar.index');
    Route::post('event-calendar', [\App\Http\Controllers\CalendarController::class, 'store'])->name('event-calendar.store');
    Route::get('event-calendar/check-event', [\App\Http\Controllers\CalendarController::class, 'check'])->name('event-calendar.check-event');

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
    Route::post('service_requests/avail', [\App\Http\Controllers\ServiceRequestController::class, 'avail'])->name('services.avail');
    Route::post('service_requests/{id}/cancel', [\App\Http\Controllers\ServiceRequestController::class, 'cancel'])->name('service_requests.cancel');

    Route::get('notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/{id}/remove', [\App\Http\Controllers\NotificationController::class, 'remove'])->name('notifications.remove');


    Route::get('reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
});

Route::middleware(['admin'])->group(function () {
    // User Controller
    Route::post('users/all', [\App\Http\Controllers\UserController::class, 'getAllUsers'])->name('users.all');
    Route::get('users/{id}/get_user', [\App\Http\Controllers\UserController::class, 'getUserById'])->name('users.info');

    // Client Controller
    Route::resource('clients', \App\Http\Controllers\ClientController::class)->except([
        'create', 'edit', 'update'
    ]);
    Route::post('clients/all', [\App\Http\Controllers\ClientController::class, 'getAllClients'])->name('clients.all');
    Route::get('clients/{id}/get_client', [\App\Http\Controllers\ClientController::class, 'getClientById'])->name('clients.info');
    Route::put('clients/{id}/update_client', [\App\Http\Controllers\ClientController::class, 'updateClient'])->name('clients.update_client');
});

