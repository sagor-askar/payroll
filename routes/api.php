<?php


use App\Http\Controllers\Api\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/sign-out', [AuthController::class, 'signout']);
    Route::get('/dash-board', [AuthController::class, 'dashBoard']);
    Route::get('/attendance-list', [AuthController::class, 'attendanceList']);
    Route::post('/attendance-store', [AuthController::class, 'attendanceStore']);
    Route::post('/attendance-re-store', [AuthController::class, 'attendanceReStore']);
    Route::get('/attendance-check', [AuthController::class, 'attendanceCheck']);
    Route::post('/attendance-update', [AuthController::class, 'attendanceUpdate']);
    Route::get('/attendance-log', [AuthController::class, 'attendanceLog']);
    Route::get('/notice-board', [AuthController::class, 'noticeBoard']);
    Route::post('/password-update', [AuthController::class, 'userUpdate']);

});
