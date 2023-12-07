<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// this routes are already prefixed with admin in RouteServiceProvider.php

Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('login', [AuthController::class, 'login']);
Route::post('auth', [AuthController::class, 'checkUser'])->name('auth');

Route::get('forgetPassword', [AuthController::class, 'showforget']);
Route::post('forgetPassword', [AuthController::class, 'forgetpassword']);
Route::post('changePassword', [AuthController::class, 'changepassword']);

Route::group(['middleware' => 'checkUserr'], function () {
    Route::get('dashboard', [AdminController::class, 'indexAdmin']);

    //Office User
    Route::group([
        'prefix' => 'user'
    ], function () {
        Route::get('/', [AdminController::class, 'indexUser']);
        Route::post('/addUser', [AdminController::class, 'saveUser']);
        Route::post('/checkEmail', [AdminController::class, 'checkOfficeUserEmail']);
        Route::post('/checkPhone', [AdminController::class, 'checkOfficeUserPhone']);
        Route::get('/exportUserExcel', [AdminController::class, 'exportOfficeUserData']);
        Route::get('/exportToCSV', [AdminController::class, 'exportToCSV']);
        //not working
        //Route::get('/exportToPDF', [AdminController::class, 'exportToPDF']);
        Route::post('/addUserExcel', [AdminController::class, 'saveUserExcel']);
        Route::post('/deleteUser', [AdminController::class, 'deleteUser']);
        Route::post('/updateUser', [AdminController::class, 'updateUser']);
    });
});
