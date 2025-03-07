<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HtmlFileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('accounts')->group(function () {
    Route::get('/', [AccountController::class, 'index']);
    Route::post('/', [AccountController::class, 'store']);
    Route::get('/{account}', [AccountController::class, 'show']);
    Route::put('/{account}', [AccountController::class, 'update']);
    Route::delete('/{account}', [AccountController::class, 'destroy']);
});
Route::post('/showSerialpaso', [HtmlFileController::class, 'getHtmlFile']);