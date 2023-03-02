<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\doctorController;
use App\Http\Controllers\feedbackController;
use App\Http\Controllers\userController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/adduser', [authController::class, 'adduser']);
Route::post('/login', [authController::class, 'login']);
Route::get('/feedback/{username}',[feedbackController::class,'filter_feedback']);
Route::post('/req/login', [authController::class, 'login']);
Route::get('/users/{id}', 'UserController@getUserData');



Route::get('/profile/{username}',[userController::class,'getUserData']);
Route::get('/doctor/{username}',[feedbackController::class,'filter_feedback']);
Route::get('/doctors',[doctorController::class,'getDoctorData']);



Route::get('/profile/{username?}',[userController::class,'getUserData']);
/*Route::post('/logout', [AuthController::class, 'logout']);*/
