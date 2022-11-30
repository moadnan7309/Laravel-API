<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\API_Controller;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::get('/student', function () {
//     return 'Laravel API Data';
// });

//Public Route

Route::get('/student',[StudentController::class,'index']);
Route::get('/student/{id}',[StudentController::class,'show']);
Route::post('/student',[StudentController::class,'store']);
Route::put('/student/{id}',[StudentController::class,'update']);
Route::delete('/student/{id}',[StudentController::class,'destroy']);
Route::get('/student/search/{city}',[StudentController::class,'search']);

// Route::post('/register',[UserController::class,'register']);
// Route::post('/login',[UserController::class,'login']);

//Protected Route
// Route::middleware('auth:sanctum')->get('/student',[StudentController::class,'index']);

// Route::middleware(['auth:sanctum'])->group(function(){
//     Route::get('/student',[StudentController::class,'index']);
//     Route::get('/student/{id}',[StudentController::class,'show']);
//     Route::post('/student',[StudentController::class,'store']);
//     Route::put('/student/{id}',[StudentController::class,'update']);
//     Route::delete('/student/{id}',[StudentController::class,'destroy']);
//     Route::get('/student/search/{city}',[StudentController::class,'search']);
//     Route::get('/logout',[UserController::class,'logout']);
// });



//Laravel Authentication API

Route::post('/register',[API_Controller::class,'register']);
Route::post('/login',[API_Controller::class,'login']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('/logout',[API_Controller::class,'logout']);
    Route::get('/logged_user',[API_Controller::class,'logged_user']);
    Route::post('/change_password',[API_Controller::class,'change_password']);
});
