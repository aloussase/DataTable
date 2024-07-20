<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LogoutController;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "users", "middleware" => "auth:sanctum"], function () {
    Route::get("/me", [UserController::class, "me"]);
});

Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);
Route::post("/logout", LogoutController::class);
