<?php

use App\Http\Controllers\ColumnController;
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
    Route::patch("/{tableId}", [TableController::class, "update"]);

    Route::prefix("/{tableId}/columns")->group(function () {
        Route::get("/", [TableController::class, "getColumns"]);
        Route::post("/", [TableController::class, "addColumn"]);
        Route::get("/{columnId}", [TableController::class, "getColumn"]);
        Route::patch("/{columnId}", [ColumnController::class, "update"]);
    });
});

Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);
Route::post("/logout", LogoutController::class);
