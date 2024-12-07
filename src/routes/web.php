<?php

use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;

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


// ログインが必要なルート（authミドルウェアを適用）
Route::middleware('auth')->group(function () {
    // ホーム画面（勤怠管理メイン画面）
    Route::get('/', [AttendanceController::class, 'index'])->name('attendance.index');

    // 勤務データ操作（打刻処理）
    Route::post('/start-work', [AttendanceController::class, 'startWork'])->name('attendance.startWork');
    Route::post('/end-work', [AttendanceController::class, 'endWork'])->name('attendance.endWork');
    Route::post('/start-rest', [AttendanceController::class, 'startRest'])->name('attendance.startRest');
    Route::post('/end-rest', [AttendanceController::class, 'endRest'])->name('attendance.endRest');

    // 日付ごとの勤怠データ表示
    Route::get('/attendance', [AttendanceController::class, 'attendance'])->name('attendance');
});

// Fortifyが提供するログイン・会員登録用のルートは自動生成されるので記述不要。
