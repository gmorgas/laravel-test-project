<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RoomsStoreRequest;
use App\Http\Resources\RoomResource;
use App\Room;
use Illuminate\Http\Request;

/**
 * Class RoomsController
 * @package App\Http\Controllers
 */
class RoomsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/rooms/{roomId}",
     *     tags={"rooms.general"},
     *     summary="Get details of a room.",
     *     description="",
     *     operationId="rooms.show",
     *     deprecated=false,
     *      @OA\Parameter(name="roomId", in="path", required=true, @OA\Schema(type="integer", format="int64")),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\MediaType(mediaType="application/vnd.api+json", @OA\Schema(ref="#/components/schemas/RoomGET"))
     *     ),
     *     @OA\Response(
     *      response=404,
     *      description="Not Found"
     *     ),
     *     @OA\Response(
     *      response=405,
     *      description="Method not allowed"
     *     ),
     *     @OA\Response(
     *      response=500,
     *      description="Server error"
     *     ),
     * )
     */

    /**
     * @param Request $request
     * @param string $roomId
     * @return RoomResource
     */
    public function show(Request $request, string $roomId)
    {
        return new RoomResource(Room::where('id', $roomId)->firstOrFail());
    }

    /**
     * @OA\Patch(
     *     path="/api/rooms",
     *     tags={"rooms.general"},
     *     summary="Create new room.",
     *     description="",
     *     operationId="rooms.store",
     *     deprecated=false,
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\MediaType(mediaType="application/vnd.api+json", @OA\Schema(ref="#/components/schemas/RoomGET"))
     *     ),
     *     @OA\Response(
     *      response=404,
     *      description="Not Found"
     *     ),
     *     @OA\Response(
     *      response=405,
     *      description="Method not allowed"
     *     ),
     *     @OA\Response(
     *      response=500,
     *      description="Server error"
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(mediaType="application/vnd.api+json", @OA\Schema(ref="#/components/schemas/RoomPOST"))
     *     ),
     * )
     */

    /**
     * @param Request $request
     * @return RoomResource
     */
    public function store(RoomsStoreRequest $request): RoomResource
    {
        $room = new Room($request->json('data.attributes'));
        $room->save();

        return new RoomResource($room);
    }
}
