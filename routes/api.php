<?php


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
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CheckNewLessonController;
use App\Http\Controllers\GreenWorldController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\pageController;
use App\Http\Controllers\ShowLessonCurrentController;
use App\Http\Controllers\ShowStudenLessonsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\OrderController;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;
use Illuminate\Support\Facades\Auth;

Auth::routes();
// 只剩下POST功能 vendor\laravel\ui\src\AuthRouteMethods.php
// app\Providers\RouteServiceProvider.php 改middleware


Route::get('sanctum/csrf-dookie', [CsrfCookieController::class, 'show']);
Route::get('/news', NewsController::class);
Route::get('/lesson/current', ShowLessonCurrentController::class);
Route::get('lesson/{id}', [LessonController::class,'show']);
Route::post('/neworder',[OrderController::class, 'store']);
Route::get('/order/{id}',[OrderController::class, 'show']);
Route::post('/greenworldcredit',[GreenWorldController::class,'createOrder']);
Route::post('/greenworldcallback',[GreenWorldController::class,'orderCallback']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/newuser', [pageController::class, "newuser"]);
    Route::resource('student', StudentController::class)->only(["index", "show", "store", "update"]);
    Route::get('/student/{id}/showstudentlessons', ShowStudenLessonsController::class);
    Route::resource('lesson', LessonController::class)->only(['index','show']);
    Route::resource('teacher', TeacherController::class)->only(['index']);

    Route::post('/checknewlesson',CheckNewLessonController::class);
});
// Route::resource('lesson', LessonController::class)->only(['show']);
// Route::get('sanctum/csrf-dookie', [CsrfCookieController::class, 'show']);
// Route::get('/news', NewsController::class);
// Route::get('/lesson/current', ShowLessonCurrentController::class);
