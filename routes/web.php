<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.index');
});
Route::get('/register', function () {
    return view('auth.register');
});
Route::get('/donate', function () {
    return view('welcome');
});
Route::get('/listdonate', function () {
    return view('backend.donate.index');
});
Route::get('/managedonate', function () {
    return view('backend.donate.donate');
});
Route::get('/manageuser', function () {
    return view('backend.user.index');
});
Route::get('/acceptdonate', function () {
    return view('backend.donate.acceptdonate');
});
Route::get('/profileaccept', function () {
    return view('backend.donate.profileaccept');
});
// Route::get('/donates', function () {
//     return view('backend.donate');
// });
Route::get('/dashboard', function () {
    return view('backend.index');
});
Route::get('/tracking', function () {
    return view('backend.donate.tracking');
});

Route::middleware('guest')->group(function(){
    Route::get('/login',[AuthController::class,'index']);
    Route::post('/login',[AuthController::class,'login'])->name('login');
});