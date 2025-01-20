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

Route::get('organizations/building/{buildingId}', [OrganizationController::class, 'indexByBuilding']);
Route::get('organizations/activity/{activityId}', [OrganizationController::class, 'indexByActivity']);
Route::get('organizations/search/name/{name}', [OrganizationController::class, 'searchByName']);
Route::get('organizations/{id}', [OrganizationController::class, 'show']);
Route::get('organizations/activity-tree/{activityId}', [OrganizationController::class, 'searchByActivityTree']);
Route::get('buildings', [BuildingController::class, 'index']);
