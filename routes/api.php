<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\pageController;
use App\Http\Controllers\ShowLessonCurrentController;
use App\Http\Controllers\ShowStudenLessonsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\LessonController;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;
use Illuminate\Support\Facades\Auth;

Auth::routes();
// 只剩下POST功能 vendor\laravel\ui\src\AuthRouteMethods.php
// app\Providers\RouteServiceProvider.php 改middleware

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/newuser', [pageController::class, "newuser"]);
    Route::resource('student', StudentController::class)->only(["index", "show", "store", "update"]);
    Route::get('/student/{id}/showstudentlessons', ShowStudenLessonsController::class);
    Route::resource('lesson', LessonController::class)->only(['index']);
    Route::resource('teacher', TeacherController::class)->only(['index']);
});
Route::get('sanctum/csrf-dookie', [CsrfCookieController::class, 'show']);
Route::get('/news', NewsController::class);
Route::get('/lesson/current', ShowLessonCurrentController::class);
