<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\FacilityController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Auth::routes();

Route::redirect('/home', 'booking')->name('home');

Route::middleware('auth')->group(function () {
    Route::middleware('role:Admin')->group(function(){
        Route::resource('facility', FacilityController::class)->except('show');
        Route::post('booking/{booking}/update-status', [BookingController::class, 'updateStatus'])->name('booking.update-status');
    });
    Route::resource('booking', BookingController::class);
});
