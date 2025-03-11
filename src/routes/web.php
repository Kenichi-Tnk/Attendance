<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CorrectController;
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

//トップページをログイン画面にリダイレクト
Route::get('/', function () {
    return redirect()->route('login');
});

//会員登録画面のルート
Route::get('register', [RegisterUserController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterUserController::class, 'store']);

//トップページをログイン画面に設定
Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.post');
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

//メール認証のルート
Route::get('email/verify', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware(['throttle:6,1'])->name('verification.send');

//ログイン後のルート
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('attendance', AttendanceController::class);
    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendances/create', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendances', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::put('/attendances/{attendance}', [AttendanceController::class, 'update'])->name('attendance.update');
    Route::get('/attendances/{attendance}', [AttendanceController::class, 'show'])->name('attendance.show');

    Route::get('/clock', [UserController::class, 'showClockPage'])->name('user.clock');
    Route::post('/attendances/clock-in', [UserController::class, 'clockIn'])->name('user.clock_in');
    Route::post('/attendances/clock-out/{id}', [UserController::class, 'clockOut'])->name('user.clock_out');
    Route::get('/attendances/{id}', [UserController::class, 'getAttendanceDetail'])->name('user.attendance_detail');
    Route::post('/attendances/{id}/request-correction', [UserController::class, 'requestCorrection'])->name('user.request_correction');
    Route::get('/corrects', [CorrectController::class, 'index'])->name('corrects.index');

    //申請関連のルート
    Route::resource('corrects', CorrectController::class);
});

// メール送信テストのルート
Route::get('/send-test-email', function () {
    Mail::raw('This is a test email', function ($message) {
        $message->to('test@example.com')
                ->subject('Test Email');
    });

    return 'Test email sent!';
});
