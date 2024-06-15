<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ResetPasswordController;

Route::redirect('/','posts');

Route::resource('posts',PostController::class);

Route::get('/{user}/posts',[DashboardController::class,'userPosts'])->name('posts.user');

Route::middleware('auth')->group(function(){
    Route::get('/dashboard',[DashboardController::class ,'index'])->middleware('verified')->name('dashboard');

    Route::post('/logout',[AuthController::class,'logout'])->name('logout');

    //email verification
    Route::get('/email/verify',[AuthController::class,'verifyNotice'])->name('verification.notice');

    //email verification handler router
    Route::get('/email/verify/{id}/{hash}',[AuthController::class,'verifyEmail'])->middleware('signed')->name('verification.verify');

    //resending verification email
    Route::post('/email/verification-notification', [AuthController::class,'resendVerificationEmail'])->middleware(['throttle:6,1'])->name('verification.send');
});

Route::middleware('guest')->group(function(){
    Route::get('/register',function(){//same view('/register',"auth.register")->name('register')
        return view('auth.register');
    })->name('register');//route name
    Route::post('/register' , [AuthController::class, 'register']);

    Route::view('/login','auth.login')->name('login');
    Route::post('/login' , [AuthController::class, 'login']);

    Route::view('/forgot-password','auth.forgot-password')->name('password.request');
    Route::post('/forgot-password', [ResetPasswordController::class,'passwordEmail']);
    Route::get('/reset-password/{token}', [ResetPasswordController::class,"passwordReset"])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class,'passwordUpdate'])->name('password.update');
});

