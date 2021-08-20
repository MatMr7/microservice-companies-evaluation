<?php

use App\Http\Controllers\Api\EvaluationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/evaluations/{company_uuid}',[EvaluationController::class, 'index']);
Route::post('/evaluations/{company_uuid}',[EvaluationController::class, 'store']);

Route::get('/',function () {
    return response()->json(['message' => 'success']);
});
