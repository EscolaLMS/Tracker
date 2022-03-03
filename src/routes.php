<?php

use EscolaLms\Tracker\Http\Controllers\TrackerController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/admin/tracks', 'middleware' => ['auth:api']], function () {
    Route::get('/routes', [TrackerController::class, 'index']);
});
