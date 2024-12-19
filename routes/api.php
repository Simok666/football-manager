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
    Route::post('coach/login', [UserAuthController::class, 'coachLogin']);
    Route::post('user', [UserAuthController::class, 'getUserAcc'])->middleware('auth:sanctum');

    Route::post('addUpdateSchedule', [AdminController::class, 'addSchedule'])->middleware('auth:sanctum');
    Route::get('getSchedule', [AdminController::class, 'getSchedule'])->middleware('auth:sanctum');

    Route::put('markAttendance/{id}', [AdminController::class, 'markAttendance'])->middleware('auth:sanctum');
    Route::get('getUserAttendance', [AdminController::class, 'getUserAttendance'])->middleware('auth:sanctum');

    Route::get('getImageDocumentation/{id}', [AdminController::class, 'getImageDocumentation'])->middleware('auth:sanctum');
    Route::post('removeImageDocumentation', [AdminController::class, 'removeImageDocumentation'])->middleware('auth:sanctum');

    Route::post('addUpdateScoring', [AdminController::class, 'addUpdateScoring'])->middleware('auth:sanctum');
    Route::get('getScoring/{userId}', [AdminController::class, 'getScoring'])->middleware('auth:sanctum');

    Route::get('getPayment', [AdminController::class, 'getPayment'])->middleware('auth:sanctum');
    Route::post('addUpdatePayment', [AdminController::class, 'addUpdatePayment'])->middleware('auth:sanctum');

    Route::get('getStatus', [AdminController::class, 'getStatus'])->middleware('auth:sanctum');
    Route::get('getEvaluation', [AdminController::class, 'getEvaluation'])->middleware('auth:sanctum');

    // Detailed Evaluation Route
    Route::get('get-detailed-evaluation', [AdminController::class, 'getDetailedEvaluation'])->middleware('auth:sanctum');
});
