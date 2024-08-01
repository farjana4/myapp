<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ResetPasswordController;

/*Route::get('/', function () {
    return view('posts.index');
})->name('home');*/

Route::view('/', 'posts.index')->name('home');

Route::resource('/posts', PostController::class);

Route::get('/{user}/posts', [DashboardController::class, 'userPosts'])->name('posts.user');

Route::middleware('auth')->group(function(){

    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('verified')->name('dashboard');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    //The Email Verification Notice
    Route::get('/email/verify', [AuthController::class, 'verifyNotice'])->name('verification.notice');

    //Email verification handler
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware(['signed'])->name('verification.verify');

    //Resending the Verification Email
    Route::post('/email/verification-notification', [AuthController::class, 'verifyHandler'])->middleware(['throttle:6,1'])->name('verification.send');


});

//routes for guest users
Route::middleware('guest')->group(function(){
    //only showing view without function
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    //The Password Reset Link Request Form
    Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
    //Password reset Handling the Form Submission
    Route::post('/forgot-password', [ResetPasswordController::class, 'passwordEmail']);
    //The Password Reset Form
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'passwordReset'])->name('password.reset');
    //Reset password Handling the Form Submission
    Route::post('/reset-password', [ResetPasswordController::class, 'PasswordUpdate'])->name('password.update');

});



