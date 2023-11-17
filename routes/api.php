<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::middleware(['basicAuth'])->group(function () {
    Route::post('/get_details', [App\Http\Controllers\API\AuthController::class, 'get_details']);
    Route::post('/get_count', [App\Http\Controllers\API\AuthController::class, 'get_count']);
    Route::post('/get_answer', [App\Http\Controllers\API\AuthController::class, 'get_answer']);
    Route::post('/employee_skills', [App\Http\Controllers\API\AuthController::class, 'employee_skills']);     
    Route::post('/test_list', [App\Http\Controllers\API\AuthController::class, 'test_list']);
    Route::post('/employee_test_request', [App\Http\Controllers\API\AuthController::class, 'employee_test_request']);  
    Route::post('/get_test_request', [App\Http\Controllers\API\AuthController::class, 'get_test_request']);

});
