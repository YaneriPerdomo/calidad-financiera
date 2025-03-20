<?php

use App\Controllers\AboutController;
use App\Controllers\AccountController;
use App\Controllers\AdminController;
use App\Controllers\ChangesPasswordController;
use App\Controllers\DataController;
use App\Controllers\IndicatorsController;
use App\Controllers\LoginController;
    use App\Controllers\CreateAccountController;
use App\Controllers\GuestsController;
use App\Controllers\ProfileController;
use App\Controllers\SignOutController;
use App\Controllers\UserController;
use Lib\Route;

    
 
    Route::get('/', function(){
        echo 'Hello World';
    });

    
    Route::get('/login', [LoginController::class, 'index']);
    Route::post('/login', [LoginController::class, 'authentication']);
    Route::get('/create-account', [CreateAccountController::class, 'index']);
    Route::post('/create-account', [CreateAccountController::class, 'add']);
    Route::get('/create-account/:id', [CreateAccountController::class, 'probando']);
    Route::get('/admin/dashboard',[AdminController::class, 'index']);
    Route::get('/user/guests', [GuestsController::class, 'index']);
    Route::get('/user/profile', [ProfileController::class, 'index']);
    Route::post('/user/profile', [ProfileController::class, 'updateData']);
    Route::get('/user/changes-password', [ChangesPasswordController::class, 'index']);
    Route::post('/user/changes-password', [ChangesPasswordController::class, 'updatePassword']);
    Route::get('/user/account', [AccountController::class, 'index']);

    Route::get('/user/data', [DataController::class, 'index']);
    Route::get('/user/indicators', [IndicatorsController::class, 'index']);
    Route::get('/user/about', [AboutController::class, 'index']);
    Route::get('/user/dashboard',[UserController::class, 'index']);
    Route::get('/signOut', [SignOutController::class, 'signOut']);
    Route::dispatch();

?>