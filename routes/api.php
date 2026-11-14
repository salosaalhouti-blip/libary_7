<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CategoryController;


Route::middleware("auth:staff")->group(function (){
    Route::get("/staff", [StaffController::class, "index"]);
    Route::post("/staff", [StaffController::class, "store"]);
    Route::get("/staff/{id}",[StaffController::class, "show"]);
    Route::put("/staff/{id}", [StaffController::class, "update"]);
    Route::delete("/staff/{id}", [StaffController::class, "destroy"]);

    Route::post("/category", [CategoryController::class, "store"]);
    Route::put("/category/{category}", [CategoryController::class, "update"]);
    Route::delete("/category/{category}", [CategoryController::class, "destroy"]);

    Route::get("/staff-me",[StaffAuthController::class, "me"]);
    Route::post("/staff-logout" ,[StaffAuthController::class, "logoout"]);

});

Route::post("/staff/login", [StaffAuthController::class, "login"]);
Route::post("/customer/login", [CustomerAuthController::class, "login"]);

Route::middleware("auth:customer")->group(function () {
    Route::apiResource("customer", App\Http\Controllers\CustomerController)->parameter("customer","customer");
    Route::get("/customer-me", [CustomerAuthController::class, "me"]);
    Route::post("/customer-logout", [CustomerAuthController::class, "logout"]);

});

Route::middleware("auth:senctum")->group(function (){
    Route::get("/category", [CategoryController::class, "index"]);
    Route::get("/category/{category}", [CategoryController::class, "show"]);
});
