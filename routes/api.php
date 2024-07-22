<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "users", "middleware" => "auth:sanctum"], function () {
    Route::get("/me", [UserController::class, "me"]);
});

Route::group(["prefix" => "reports", "middleware" => "auth:sanctum"], function () {
    Route::get("/excel", [ReportsController::class, "generateExcelReport"]);
});

Route::group(["prefix" => "tables", "middleware" => "auth:sanctum"], function () {
    Route::get("/", [TableController::class, "index"]);
    Route::post("/", [TableController::class, "store"]);
    Route::get("/{tableId}/columns", [TableController::class, "getColumns"]);
    Route::post("/{tableId}/columns", [TableController::class, "addColumn"]);
});

Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);
Route::post("/logout", LogoutController::class);
