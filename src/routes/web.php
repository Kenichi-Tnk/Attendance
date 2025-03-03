<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('register', [RegisterUserController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterUserController::class, 'store']);

Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('email/verify', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware(['throttle:6,1'])->name('verification.send');

Route::middleware(['auth'])->group(function () {
    Route::get('/attendances', [UserController::class, 'getAttendances'])->name('user.attendances');
    Route::get('/clock', [UserController::class, 'showClockPage'])->name('user.clock');
    Route::post('/attendances/clock-in', [UserController::class, 'clockIn'])->name('user.clock_in');
    Route::post('/attendances/clock-out/{id}', [UserController::class, 'clockOut'])->name('user.clock_out');
    Route::get('/attendances/{id}', [UserController::class, 'getAttendanceDetail'])->name('user.attendance_detail');
    Route::post('/attendances/{id}/request-correction', [UserController::class, 'requestCorrection'])->name('user.request_correction');
    Route::get('/requests', [UserController::class, 'getRequests'])->name('user.requests');
});

// メール送信テストのルート
Route::get('/send-test-email', function () {
    Mail::raw('This is a test email', function ($message) {
        $message->to('test@example.com')
                ->subject('Test Email');
    });

    return 'Test email sent!';
});
