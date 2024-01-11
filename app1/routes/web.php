<?php

use App\Http\Controllers\SsoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    
    if (Cookie::has('ssotoken') && !Auth::check()) {

        return redirect()->route('sso', Cookie::get('ssotoken'));
    }
    return view('welcome');
});

Route::get('/sso/{token}', SsoController::class)->name('sso');
Auth::routes(
    ['register' => false, 'reset' => false, 'verify' => false],
);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
