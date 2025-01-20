<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Building;
use App\Models\Organization;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Organizations",
 *     description="API для работы с организациями"
 * )
 */
/**
 * @OA\Schema(
 *     schema="Organization",
 *     type="object",
 *     required={"id", "name"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Organization Name"),
 *     @OA\Property(property="phones", type="array", @OA\Items(type="string", example="123-456-7890")),
 
 * )
 */

 class OrganizationController extends Controller
 {
     /**
      * @OA\Get(
      *     path="/api/organizations/building/{buildingId}",
      *     summary="Get organizations by building",
      *     description="Returns organizations based on building ID, including phones and activities",
      *     tags={"Organizations"},
      *     security={{
      *         "apiKey": {}
      *     }},
      *     @OA\Parameter(
      *         name="buildingId",
      *         in="path",
      *         required=true,
      *         @OA\Schema(type="integer")
      *     ),
      *     @OA\Response(
      *         response=200,
      *         description="List of organizations",
      *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Organization"))
      *     ),
      *     @OA\Response(
      *         response=404,
      *         description="Building not found"
      *     ),
      *     @OA\Response(
      *         response=500,
      *         description="Internal server error"
      *     )
      * )
      */
     public function indexByBuilding($buildingId)
     {
         $building = Building::findOrFail($buildingId);
         $organizations = $building->organizations()->with('phones', 'activities')->get();
         return response()->json($organizations);
     }
 
     /**
      * @OA\Get(
      *     path="/api/organizations/activity/{activityId}",
      *     summary="Get organizations by activity",
      *     description="Returns organizations related to a specific activity, including phones",
      *     tags={"Organizations"},
      *     security={{
      *         "apiKey": {}
      *     }},
      *     @OA\Parameter(
      *         name="activityId",
      *         in="path",
      *         required=true,
      *         @OA\Schema(type="integer")
      *     ),
      *     @OA\Response(
      *         response=200,
      *         description="List of organizations",
      *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Organization"))
      *     ),
      *     @OA\Response(
      *         response=404,
      *         description="Activity not found"
      *     ),
      *     @OA\Response(
      *         response=500,
      *         description="Internal server error"
      *     )
      * )
      */
     public function indexByActivity($activityId)
     {
         $activity = Activity::with('organizations')->findOrFail($activityId);
         $organizations = $activity->organizations()->with('phones')->get();
         return response()->json($organizations);
     }
 
     /**
 * @OA\Get(
 *     path="/api/organizations/search/name/{name}",
 *     summary="Search organizations by name",
 *     description="Search for organizations by name and returns matching results",
 *     tags={"Organizations"},
 *     security={{
 *         "apiKey": {}
 *     }},
 *     @OA\Parameter(
 *         name="name",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of organizations matching the name",
 *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Organization"))
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
     public function searchByName($name)
     {
         $organizations = Organization::where('name', 'like', '%' . $name . '%')->with('phones', 'activities')->get();
         return response()->json($organizations);
     }
 
     /**
      * @OA\Get(
      *     path="/api/organizations/{id}",
      *     summary="Get organization by ID",
      *     description="Returns detailed information about an organization by its ID",
      *     tags={"Organizations"},      
      *     security={{
      *         "apiKey": {}
      *     }},
      *     @OA\Parameter(
      *         name="id",
      *         in="path",
      *         required=true,
      *         @OA\Schema(type="integer")
      *     ),
      *     @OA\Response(
      *         response=200,
      *         description="Organization details",
      *         @OA\JsonContent(ref="#/components/schemas/Organization")
      *     ),
      *     @OA\Response(
      *         response=404,
      *         description="Organization not found"
      *     ),
      *     @OA\Response(
      *         response=500,
      *         description="Internal server error"
      *     )
      * )
      */
     public function show($id)
     {
         $organization = Organization::with('building', 'phones', 'activities')->findOrFail($id);
         return response()->json($organization);
     }
 
     /**
      * @OA\Get(
      *     path="/api/organizations/activity-tree/{activityId}",
      *     summary="Get organizations by activity tree",
      *     description="Returns organizations related to the activity and its children",
      *     tags={"Organizations"},  
      *     security={{
      *         "apiKey": {}
      *     }},
      *     @OA\Parameter(
      *         name="activityId",
      *         in="path",
      *         required=true,
      *         @OA\Schema(type="integer")
      *     ),
      *     @OA\Response(
      *         response=200,
      *         description="List of organizations",
      *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Organization"))
      *     ),
      *     @OA\Response(
      *         response=404,
      *         description="Activity not found"
      *     ),
      *     @OA\Response(
      *         response=500,
      *         description="Internal server error"
      *     )
      * )
      */
     public function searchByActivityTree($activityId)
     {
         $activity = Activity::with('children')->findOrFail($activityId);
         $activityIds = $activity->children->pluck('id')->push($activityId);
         $organizations = Organization::whereHas('activities', function($query) use ($activityIds) {
             $query->whereIn('activity_id', $activityIds);
         })->with('phones', 'activities')->get();
         return response()->json($organizations);
     }
 }
 
