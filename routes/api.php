<?php

<<<<<<< HEAD
use App\Http\Controllers\appointmentController;
use App\Http\Controllers\authController;
use App\Http\Controllers\doctorController;
use App\Http\Controllers\feedbackController;
use App\Http\Controllers\userController;
=======
>>>>>>> 1f2f309 (after installing needed packages)
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

<<<<<<< HEAD

Route::post('/adduser', [authController::class, 'adduser']);      //right
Route::post('/login', [authController::class, 'login']);//right
Route::get('/chkuname/{username}', [authController::class, 'chkuname']);      //right
Route::get('/user', [authController::class, 'user']);

Route::get('/feedback/',[feedbackController::class,'filter_feedback']);      //right
Route::get('/profile/{username}',[userController::class,'getUserData']);           //right

Route::get('/doctors',[doctorController::class,'getDoctorData']);      //right

//appointments
Route::post('schedule/appointments',[appointmentController::class,'sched_appointment']);
Route::post('book/appointment',[appointmentController::class,'book_appointment']);
Route::post('cancel/appointment',[appointmentController::class,'cancel_appointment']);
Route::get('get/appointments',[appointmentController::class,'get_appointments']);
Route::post('get/slots',[appointmentController::class,'get_slots']);

/*Route::post('/logout', [AuthController::class, 'logout']);*/
=======
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
>>>>>>> 1f2f309 (after installing needed packages)
