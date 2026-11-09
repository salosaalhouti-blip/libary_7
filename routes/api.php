<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffauthController;


Route::middleware("auth:sanctum")->group(function (){
    Route::get("/staff", [StaffController::class, "index"]);
    Route::post("/staff", [StaffController::class, "store"]);
    Route::get("/staff/{id}",[StaffController::class, "show"]);
    Route::put("/staff/{id}", [StaffController::class, "update"]);
    Route::delete("/staff/{id}", [StaffController::class, "destroy"]);
    Route::get("/staff-me",[StaffAuthController::class, "me"]);
    Route::post("/staff-logout" ,[StaffAuthController::class, "logoout"]);

});

Route::post("/staff/login", [StaffAuthController::class, "login"]);
Route::apiResource("customer", App\Http\Controllers\CustomerController::class);
