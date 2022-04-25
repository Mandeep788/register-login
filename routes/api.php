<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\dummyapi;
// use App\Http\Controllers\deviceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordresetController;


//public Routes
Route::post("/register",[UserController::class,'register']);
Route::post("/login",[UserController::class,'login']);
Route::post("/send_reset_parrword_email",[PasswordresetController::class,'send_reset_parrword_email']);




//protected Routes
Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('/logout',[UserController::class,'logout']);
    Route::get("/loggeduser",[UserController::class,'logged_user']);
    Route::post("/changepassword",[UserController::class,'change_password']);

});


// Route::middleware('auth:sanctum')->get('/user',  unction (Request $request) {
//     return $request->user();
// });
// Route::get("data",[dummyapi::class,'getData']);
// Route::get("list",[deviceController::class,'list']);


