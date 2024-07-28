<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

Route::prefix('surveys')->group(function () {
    Route::post('/', [Controller::class, 'PostSurvey']);
    Route::get('/', [Controller::class, 'GetSurvey']);
    Route::get('{survey_id}', [Controller::class, 'GetSurveyId']);
    Route::post('{id}/responses', [Controller::class, 'PostSurveiResponses']);
    Route::get('{id}/responses', [Controller::class, 'GetSurveiResponses']);
    Route::prefix('question')->group(function () {
        Route::post('{id}', [Controller::class, 'PostQuestion']);
    });
});
