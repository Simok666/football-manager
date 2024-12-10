<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Backend\AdminController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {
    Route::post('register', [UserAuthController::class, 'register']);
    Route::get('getUser', [AdminController::class, 'getUserAccount']);

    Route::get('getPosition', [AdminController::class, 'getPosition']);
    Route::get('getContribution', [AdminController::class, 'getContribution']);

    Route::post('userManagement', [AdminController::class, 'userManagement']);
    Route::get('getCoach', [AdminController::class, 'getCoachAccount']);
    Route::post('addUpdateCoach', [AdminController::class, 'addUpdateCoach']);

    Route::post('user/login', [UserAuthController::class, 'login']);
    Route::post('admin/login', [UserAuthController::class, 'adminLogin']);
    Route::post('user', [UserAuthController::class, 'getUserAcc'])->middleware('auth:sanctum');
});

