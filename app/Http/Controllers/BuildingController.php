<?php

namespace App\Http\Controllers;

use App\Models\Building;

/**
 * @OA\Tag(
 *     name="Buildings",
 *     description="API для работы с зданиями"
 * )
 */
/**
 * @OA\Schema(
 *     schema="Building",
 *     type="object",
 *     required={"id", "name"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Building Name"),
 *     @OA\Property(
 *         property="organizations",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Organization")
 *     )
 * )
 */

class BuildingController extends Controller
{
/**
 * @OA\Get(
 *     path="/api/buildings",
 *     summary="Get list of buildings",
 *     description="Returns a list of buildings with their organizations",
 *     tags={"Buildings"},
 *     @OA\Response(
 *         response=200,
 *         description="List of buildings",
 *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Building"))
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
    public function index()
    {
        $buildings = Building::with('organizations')->get();
        return response()->json($buildings);
    }
}
