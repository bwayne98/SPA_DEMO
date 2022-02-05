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
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\pageController;
use App\Http\Controllers\ShowLessonCurrentController;
use App\Http\Controllers\ShowStudenLessonsController;
use App\Http\Controllers\StudentController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/newuser',[pageController::class,"newuser"]);
// Route::post('/login',[pageController::class,"login"]);
// Route::get('/login',[pageController::class,"getUser"]);
Route::get('/teachers', [TeacherController::class, "index"]);
Route::resource('student', StudentController::class)->only(["index","show","store","update"]);
Route::get('/student/{id}/showstudentlessons',ShowStudenLessonsController::class);
Route::get('/lesson/current',ShowLessonCurrentController::class);