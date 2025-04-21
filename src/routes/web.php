<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CorrectController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminAttendanceController;
use App\Http\Controllers\Admin\AdminStaffController;
use App\Http\Controllers\Admin\AdminCorrectsController;
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

// 管理者用ログインルート
Route::get('admin/login', [AuthenticatedSessionController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('admin/login', [AuthenticatedSessionController::class, 'store']);
Route::post('admin/logout', [AuthenticatedSessionController::class, 'destroy'])->name('admin.logout');

//ユーザー用ルート
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('attendance', AttendanceController::class);
    //勤怠一覧画面
    Route::get('/attendances', [AttendanceController::class, 'index'])->name('user.attendance.index');
    //勤怠登録画面
    Route::get('/attendances/create', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendances', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::put('/attendance/{attendance}', [AttendanceController::class, 'update'])->name('attendance.update');
    //勤怠詳細画面
    Route::get('/attendance/{id}', [AttendanceController::class, 'show'])->name('user.attendance.show');

    Route::post('/attendance/{id}/correct', [AttendanceController::class, 'correct'])->name('attendance.correct');

    Route::get('/clock', [UserController::class, 'showClockPage'])->name('user.clock');

    Route::post('/attendances/clock-in', [UserController::class, 'clockIn'])->name('user.clock_in');

    Route::post('/attendances/clock-out/{id}', [UserController::class, 'clockOut'])->name('user.clock_out');

    Route::get('/attendances/{id}', [UserController::class, 'getAttendanceDetail'])->name('user.attendance_detail');

    Route::post('/attendances/{id}/request-correction', [UserController::class, 'requestCorrection'])->name('user.request_correction');
    
    Route::get('/corrects', [CorrectController::class, 'index'])->name('user.corrects.index');

    Route::post('/corrects/{id}', [CorrectController::class, 'store'])->name('user.corrects.store');

    //申請関連のルート
    Route::resource('corrects', CorrectController::class);
});

//管理者用のルート
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/attendance', [AdminAttendanceController::class, 'index'])->name('admin.attendance.index');
    Route::get('/admin/attendance/{id}', [AdminAttendanceController::class, 'show'])->name('admin.attendance.show'); // 詳細画面ルート
    Route::post('/admin/attendance/{id}/update', [AdminAttendanceController::class, 'update'])->name('admin.attendance.update'); // 勤怠詳細更新
    Route::get('/admin/staff', [AdminStaffController::class, 'index'])->name('admin.staff.index');
    Route::get('/admin/staff/{id}', [AdminStaffController::class, 'show'])->name('admin.staff.show'); // 仮組みの詳細画面ルート
    Route::get('/admin/staff/{id}/csv', [AdminStaffController::class, 'exportCsv'])->name('admin.staff.csv'); // CSV出力
    Route::get('/admin/corrects', [AdminCorrectsController::class, 'index'])->name('admin.corrects.index');//修正申請一覧
    Route::get('/admin/corrects/{id}', [AdminCorrectsController::class, 'show'])->name('admin.corrects.show');//修正申請詳細
    Route::post('/admin/corrects/{id}/approve', [AdminCorrectsController::class, 'approve'])->name('admin.corrects.approve');//修正申請承認
    // 他の管理者用ルートを追加
});

// メール送信テストのルート
Route::get('/send-test-email', function () {
    Mail::raw('This is a test email', function ($message) {
        $message->to('test@example.com')
                ->subject('Test Email');
    });

    return 'Test email sent!';
});
