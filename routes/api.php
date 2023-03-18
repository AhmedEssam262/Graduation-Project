<?php

use App\Http\Controllers\appointmentController;
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
Route::post('/adduser', [authController::class, 'adduser']);      //right
Route::post('/login', [authController::class, 'login']);//right
Route::get('/chkuname/{username}', [authController::class, 'chkuname']);      //right

Route::get('/feedback/{username}',[feedbackController::class,'filter_feedback']);
Route::get('/profile/{username}',[userController::class,'getUserData']);           //right

Route::get('/doctors/{username}',[feedbackController::class,'filter_feedback']);
Route::get('/doctors',[doctorController::class,'getDoctorData']);      //right

//appointments
Route::post('schedule/appointments',[appointmentController::class,'sched_appointment']);
Route::post('book/appointment',[appointmentController::class,'book_appointment']);
Route::post('cancel/appointment',[appointmentController::class,'cancel_appointment']);
Route::post('get/slots',[appointmentController::class,'get_slots']);

/*Route::post('/logout', [AuthController::class, 'logout']);*/
