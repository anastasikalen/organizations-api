<?php

use App\Http\Controllers\BuildingController;
use App\Http\Controllers\OrganizationController;
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

Route::middleware('check_api_key')->get('organizations/building/{buildingId}', [OrganizationController::class, 'indexByBuilding']);
Route::middleware('check_api_key')->get('organizations/activity/{activityId}', [OrganizationController::class, 'indexByActivity']);
Route::middleware('check_api_key')->get('organizations/search/name/{name}', [OrganizationController::class, 'searchByName']);
Route::middleware('check_api_key')->get('organizations/{id}', [OrganizationController::class, 'show']);
Route::middleware('check_api_key')->get('organizations/activity-tree/{activityId}', [OrganizationController::class, 'searchByActivityTree']);
Route::middleware('check_api_key')->get('buildings', [BuildingController::class, 'index']);