<?php

use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\RoomController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::controller(RoomController::class)->group(function(){
    Route::get('room', 'index');
    Route::get('room/create', 'create');
    Route::post('room/save', 'save');
});
