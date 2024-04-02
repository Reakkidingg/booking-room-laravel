<?php

use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\RoomController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::controller(RoomController::class)->group(function(){
    Route::get('room', 'index');
    Route::get('room/create', 'create');
    Route::get('room/edit/{id}', 'edit');
    Route::post('room/save', 'save');
    Route::post('room/update', 'update');
    Route::get('room/search', 'search')->name('room.search');
    Route::get('room/delete/{id}', 'delete')->name('room.delete');
    Route::get('room/search', 'search')->name('room.search');
});
