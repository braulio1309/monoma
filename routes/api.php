<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidateController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth', [AuthController::class, 'login']);
Route::middleware(['jwt.auth'])->group(function () {
    Route::controller(CandidateController::class)
        ->group(function () {
            Route::get('/leads', [CandidateController::class, 'index']);
            Route::get('/lead/{id}', [CandidateController::class, 'show']);
            Route::post('/lead', [CandidateController::class, 'store']);
        });
});

