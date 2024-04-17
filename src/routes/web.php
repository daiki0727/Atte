<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
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

//メール認証ユーザーのみホーム画面許可
Route::get('/', [AttendanceController::class, 'attend'])
    ->middleware(['auth', 'verified'])
    ->name('stamp');

//メール認証確認画面から新規登録画面へ遷移するためのルート
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

//新規ユーザー登録処理
Route::post('/register', [RegisteredUserController::class, 'store']);

//ログアウト処理
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

//打刻処理
Route::post('/', [AttendanceController::class, 'punch'])
    ->name('punch');

//日付一覧画面
Route::get('/attendance_date', [AttendanceController::class, 'indexDate'])
    ->name('attendance.date');

//ユーザー一覧画面
Route::get('/attendance_user', [AttendanceController::class, 'indexUser'])
    ->name('attendance.user');

//ユーザー検索
Route::get('/attendance_user/search', [AttendanceController::class, 'search'])
    ->name('attendance.user.search');

//選択したユーザーの勤怠表表示
Route::get('/user_detail/{id}', [AttendanceController::class, 'userDetail'])
    ->name('user.detail');
