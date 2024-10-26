<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PrayerController;
use App\Http\Controllers\TestimonyController;
use App\Http\Controllers\GivingController;
use App\Http\Controllers\LiveStreamController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminCallScheduleController;

Route::post('prayer/voice', [PrayerController::class, 'sendVoicePrayer']);
    Route::post('prayer/text', [PrayerController::class, 'sendTextPrayer']);

// Route::middleware(['auth', 'admin'])->group(function() {
    Route::get('/callschedule', [AdminCallScheduleController::class, 'index'])->name('callschedule.index');
    Route::get('/callschedule/create', [AdminCallScheduleController::class, 'create'])->name('callschedule.create');
    Route::post('/callschedule/store', [AdminCallScheduleController::class, 'store'])->name('callschedule.store');
    Route::post('/callschedule/{id}/live', [AdminCallScheduleController::class, 'makeLive'])->name('callschedule.live');
// });




Route::post('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
Route::post('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/reports/users', [ReportController::class, 'usersReport'])->name('reports.users');
Route::get('/reports/testimonies', [ReportController::class, 'testimoniesReport'])->name('reports.testimonies');
Route::get('/reports/prayers', [ReportController::class, 'prayersReport'])->name('reports.prayers');
Route::get('/reports/payments', [ReportController::class, 'paymentsReport'])->name('reports.payments');


Route::get('/admin/live-stream', [LiveStreamController::class, 'showAdminInterface'])->name('admin.live-stream');
Route::post('/admin/live-stream', [LiveStreamController::class, 'updateLiveStream'])->name('admin.live-stream.update');


Route::get('/subscription/callback', [GivingController::class, 'handleCallback'])->name('payment.callback');

// Route::post('/subscription/callback', [GivingController::class, 'handleCallback'])->name('payment.callback');


Route::post('admin-register', [UserController::class, 'registeradmin'])->name('admin-register');
Route::post('admin-login', [UserController::class, 'adminlogin'])->name('admin-login');


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

Route::get('/', function () {
    return view('admin/login');
})->name('admin.login');

Route::get('/register', function () {
    return view('admin/register');
})->name('admin.register');
Route::get('/dashboard', function () {
    return view('admin/index');
})->name('admin.dashboard');


Route::get('/sendprayer', function () {
    return view('prayer/send_voice_prayer.blade');
})->name('sendprayer');