<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth')->group(function () {
    Route::get('/', [AttendanceController::class, 'index']);
    Route::post('/attendances/start', [AttendanceController::class, 'start']);
    Route::post('/attendances/end', [AttendanceController::class, 'end']);
    Route::patch('/attendances/{attendance_id}', [AttendanceController::class, 'update']);
    Route::delete('/attendances/{attendance_id}', [AttendanceController::class, 'destroy']);
    Route::post('/attendances', [AttendanceController::class, 'store']);

    Route::get('/mypage', [UserController::class, 'mypage']);
});

