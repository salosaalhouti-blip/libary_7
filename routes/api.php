<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\CtegoryController;
use App\Http\Controllers\BookController;


Route::middleware("auth:staff")->group(function (){
    Route::get("/staff", [StaffController::class, "index"]);
    Route::post("/staff", [StaffController::class, "store"]);
    Route::get("/staff/{id}",[StaffController::class, "show"]);
    Route::put("/staff/{id}", [StaffController::class, "update"]);
    Route::delete("/staff/{id}", [StaffController::class, "destroy"]);

    Route::post("/category", [CtegoryController::class, "store"]);
    Route::put("/category/{category}", [CtegoryController::class, "update"]);
    Route::delete("/category/{category}", [CtegoryController::class, "destroy"]);

    Route::get("/staff-me",[StaffAuthController::class, "me"]);
    Route::post("/staff-logout" ,[StaffAuthController::class, "logoout"]);

    Route::post("/book", [BookController::class, "store"]);
    Route::put("/book/{book}", [BookController::class, "update"]);
    Route::delete("/book/{book}", [BookController::class, "destroy"]);

    Route::apiResource("customer", App\Http\Controllers\CustomerController::class)->parameter("customer","customer");

    Route::put("/borrow", [borrowingsController::class, "markAsReturned"]);
});


Route::post("/staff/login", [StaffAuthController::class, "login"]);
Route::post("/customer/login", [CustomerAuthController::class, "login"]);



Route::middleware("auth:customer")->group(function () {
    
    Route::get("/customer-me", [CustomerAuthController::class, "me"]);
    Route::post("/customer-logout", [CustomerAuthController::class, "logout"]);

    Route::post("/borrow", [borrowingsController::class, "borrow"]);
    Route::get("/borrow", [borrowingsController::class, "index"]);
    Route::delete("/borrow/{id}", [borrowingsController::class, "destroy"]);
});


Route::middleware("auth:sanctum")->group(function (){
    Route::get("/category", [CtegoryController::class, "index"]);
    Route::get("/category/{category}", [CtegoryController::class, "show"]);
    Route::get("/book", [BookController::class, "index"]);
    Route::get("/book/{book}", [BookController::class, "show"]);
});
