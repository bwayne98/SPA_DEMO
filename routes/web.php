<?php

use App\Http\Controllers\GreenWorldController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

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
use App\Http\Controllers\pageController;

Route::get('/php',function(){
    return phpinfo();
});


Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '^(?!api\/)[\/\w\.\,-]*');

Route::get('/',function () {
    return view('welcome');
})->name('home');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
