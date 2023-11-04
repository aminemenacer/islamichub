<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DonationController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/users', [UserController::class, 'index']);
Route::get('/feedback', [FeedbackController::class, 'index']);
Route::get('/payments', [PaymentController::class, 'index']);
Route::get('/donations', [DonationController::class, 'index']);
