<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.index');
});

Route::get('/donate', function () {
    return view('donate');
});
Route::get('/listdonate', function () {
    return view('backend.donate.index');
});
Route::get('/managedonate', function () {
    return view('backend.donate.donate');
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

Route::get('/tracking', function () {
    return view('backend.donate.tracking');
});

Route::middleware('guest')->group(function(){

    Route::get('/register',[AuthController::class,'registershow']);
    Route::post('/register',[AuthController::class,'register'])->name('register');
    Route::get('/login',[AuthController::class,'index']);
    Route::post('/login',[AuthController::class,'login'])->name('login');
});


Route::middleware('auth')->group(function(){
    Route::get('/dashboard', function () {
        return view('backend.index');
    });

    Route::middleware('administrator')->group(function(){
        // manage user
    Route::resource('/manageuser',UserController::class);
    Route::post('users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
    
    
    Route::get('/logout',[AuthController::class,'logout']);
});

Route::get('/404',function(){
    return view('404');
});