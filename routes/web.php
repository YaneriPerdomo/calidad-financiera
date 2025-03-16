<?php

use App\Controllers\AdminController;
use App\Controllers\LoginController;
    use App\Controllers\CreateAccountController;
use App\Controllers\UserController;
use Lib\Route;

    
 
    Route::get('/', function(){
        echo 'Hello World';
    });

    
    Route::get('/login', [LoginController::class, 'index']);
    Route::post('/login', [LoginController::class, 'authentication']);
    Route::get('/create-account', [CreateAccountController::class, 'index']);
    Route::post('/create-account', [CreateAccountController::class, 'add']);
    Route::get('/admin/dashboard',[AdminController::class, 'index']);
    Route::get('/user/dashboard',[UserController::class, 'index']);
     
    Route::dispatch();

?>