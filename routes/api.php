<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\PrayerController;
use App\Http\Controllers\TestimonyController;
use App\Http\Controllers\GivingController;
use App\Http\Controllers\LiveStreamController;
use App\Http\Controllers\AdminCallScheduleController;

// API route for mobile user to view schedules
Route::get('/api/schedules', [AdminCallScheduleController::class, 'getSchedules']);

Route::get('/live-stream', [LiveStreamController::class, 'getLiveStreamLink'])->name('api.live-stream');

Route::post('/give', [GivingController::class, 'initiatePayment']);
Route::get('/subscription/callback', [GivingController::class, 'handleCallback'])->name('payment.callback');


Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);


    Route::post('prayer/voice', [PrayerController::class, 'sendVoicePrayer']);
    Route::post('prayer/text', [PrayerController::class, 'sendTextPrayer']);
    Route::post('testimony/voice', [TestimonyController::class, 'sendVoiceTestimony']);
    Route::post('testimony/text', [TestimonyController::class, 'sendTextTestimony']);




