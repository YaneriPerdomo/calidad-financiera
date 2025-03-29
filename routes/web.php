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
use App\Controllers\ProfileAdminController;
use App\Controllers\ProfileController;
use App\Controllers\SignOutController;
use App\Controllers\UserController;
use Lib\Route;

Route::get('/', function () {
    echo 'Hello World';
});

// Rutas públicas (sin autenticación)
Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'authentication']);
Route::get('/create-account', [CreateAccountController::class, 'index']);
Route::post('/create-account', [CreateAccountController::class, 'add']);
Route::get('/create-account/:id', [CreateAccountController::class, 'probando']);
Route::get('/signOut', [SignOutController::class, 'signOut']);

// Rutas de usuario (con autenticación)
Route::get('/user/dashboard', [UserController::class, 'index']);
Route::get('/user/guests/:page', [GuestsController::class, 'show']);
Route::get('/user/add-guest', [GuestsController::class, 'showAddForm']);
Route::post('/user/add-guest', [GuestsController::class, 'addData']);
Route::post('/user/guest', [GuestsController::class, 'operationData']);
Route::get('/user/guest/add', [GuestsController::class, 'create']);
Route::get('/user/guest/:id/modify', [GuestsController::class, 'showData']);

Route::get('/user/profile', [ProfileController::class, 'index']);
Route::post('/user/profile', [ProfileController::class, 'updateData']);
Route::get('/user/changes-password', [ChangesPasswordController::class, 'index']);
Route::post('/user/changes-password', [ChangesPasswordController::class, 'updatePassword']);
Route::get('/user/account', [AccountController::class, 'index']);
Route::get('/user/data', [DataController::class, 'index']);
Route::get('/user/indicators', [IndicatorsController::class, 'index']);
Route::get('/user/about', [AboutController::class, 'index']);

// Rutas de administrador (con autenticación)
Route::get('/admin/dashboard/:page', [AdminController::class, 'index']);
Route::get('/admin/about', [AboutController::class, 'index']);
Route::get('/admin/profile', [ProfileAdminController::class, 'index']);
Route::post('/admin/profile', [ProfileAdminController::class, 'updateData']);
Route::post('/admin/changes-password', [ChangesPasswordController::class, 'updatePassword']);
Route::get('/admin/changes-password', [ProfileAdminController::class, 'ShowChangesPassword']);
Route::get('/admin/indicators/:pageE/:pageI', [IndicatorsController::class, 'index']);
Route::get('/admin/add-indicator', [IndicatorsController::class, 'showAddForm']);
Route::post('/admin/indicator/add', [IndicatorsController::class, 'AddIndicator']);
Route::get('/admin/indicator/add', [IndicatorsController::class, 'create']);
Route::get('/admin/indicator/:id-egreso/modify', [IndicatorsController::class, 'Modify']);
Route::get('/admin/indicator/:id-ingreso/modify', [IndicatorsController::class, 'Modify']);
Route::post('/admin/indicator/:id-egreso/modify', [IndicatorsController::class, 'Operation']);
Route::post('/admin/indicator/:id-ingreso/modify', [IndicatorsController::class, 'Operation']);


//Rutas de invitado (con autenticacion)
Route::get('/guest/dashboard' , [GuestsController::class, 'index']);
Route::get('/guest/profile' , [ProfileController::class, 'index']);
Route::get('/guest/about' , [AboutController::class, 'index']);


Route::dispatch();

?>