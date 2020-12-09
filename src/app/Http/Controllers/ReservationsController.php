<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ReservationConfirmRequest;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\RoomResource;
use App\Reservation;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ReservationsController
 * @package App\Http\Controllers
 */
class ReservationsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/reservations/{reservationId}",
     *     tags={"reservations.general"},
     *     summary="Get details of a reservation.",
     *     description="",
     *     operationId="reservations.show",
     *     deprecated=false,
     *      @OA\Parameter(name="reservationId", in="path", required=true, @OA\Schema(type="integer", format="int64")),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\MediaType(mediaType="application/vnd.api+json", @OA\Schema(ref="#/components/schemas/ReservationGET"))
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
     * @param int $reservationId
     * @return ReservationResource
     */
    public function show(Request $request, int $reservationId): ReservationResource
    {
        return new ReservationResource(
            Reservation::where('id', $reservationId)
                ->firstOrFail()
        );
    }


    /**
     * @OA\Get(
     *     path="/api/reservations/{reservationId}/room",
     *     tags={"reservations.general"},
     *     summary="Get details of related room.",
     *     description="",
     *     operationId="reservations.rooms.show",
     *     deprecated=false,
     *      @OA\Parameter(name="reservationId", in="path", required=true, @OA\Schema(type="integer", format="int64")),
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
     * @param int $reservationId
     * @return RoomResource
     */
    public function room(Request $request, int $reservationId): RoomResource
    {
        /** @var Reservation $reservation */
        $reservation = Reservation::where('id', $reservationId)
            ->firstOrFail();

        return new RoomResource(
            $reservation
                ->room()
                ->withTrashed()
                ->firstOrFail()
        );
    }

    /**
     * @OA\Post(
     *     path="/api/reservations/confirm",
     *     tags={"reservations.general"},
     *     summary="Change the specific reservation's status into confirmed",
     *     description="",
     *     operationId="reservations.confirm",
     *     deprecated=false,
     *      @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\MediaType(mediaType="application/vnd.api+json", @OA\Schema(ref="#/components/schemas/ReservationGET"))
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
     *          @OA\MediaType(mediaType="application/vnd.api+json", @OA\Schema(ref="#/components/schemas/ReservationCONFIRM"))
     *     ),
     * )
     */

    /**
     * @param ReservationConfirmRequest $request
     * @return JsonResponse
     */
    public function setReservationConfirm(ReservationConfirmRequest $request): JsonResponse
    {
        $reservationId = $request->json('data.id');
        $roomId = $request->json('data.attributes.room_id');
        $reservation = Reservation::where('id', $reservationId)
            ->first();

        if($this->checkDateReservation($roomId, $reservation)) {
            return response()->json(array('data' => array(
                'type' => 'reservations',
                'attributes' => array(
                    'status' => 'validation error',
                    'messages' => 'This room is simultaneously allocated to other bookings in this time.'
                )
            )),422);
        }

        try {
            Reservation::where('id', $reservationId)->update(['room_id' => $roomId, 'status' => 'confirmed']);
            $reservation = Reservation::where('id', $reservationId)
                ->firstOrFail();
            return response()->json(array('data' => new RoomResource(
                $reservation
                    ->room()
                    ->withTrashed()
                    ->firstOrFail()
            )),200);
        } catch (\Illuminate\Database\QueryException $e) {
            throw new HttpResponseException(response()->json(array('data' => array(
                'type' => 'rooms',
                'attributes' => array(
                    $e->message()
                )
            )),500));
        }
    }

    /**
     * @OA\Post(
     *     path="/api/reservations/completed",
     *     tags={"reservations.general"},
     *     summary="Change the specific reservation's status into completed",
     *     description="",
     *     operationId="reservations.completed",
     *     deprecated=false,
     *      @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\MediaType(mediaType="application/vnd.api+json", @OA\Schema(ref="#/components/schemas/ReservationGET"))
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
     *          @OA\MediaType(mediaType="application/vnd.api+json", @OA\Schema(ref="#/components/schemas/ReservationCOMPLETED"))
     *     ),
     * )
     */

    /**
     * @param ReservationConfirmRequest $request
     * @return RoomResource
     */
    public function setReservationCompleted(ReservationConfirmRequest $request): RoomResource
    {
        $reservationId = $request->json('data.id');
        $reservation = Reservation::where('id', $reservationId)
            ->firstOrFail();
        $reservation->status = 'completed';
        $reservation->save();

        return new RoomResource(
            $reservation
                ->room()
                ->withTrashed()
                ->firstOrFail()
        );
    }

    /**
     * @param $roomId
     * @param $reservation
     * @return bool
     */
    private function checkDateReservation($roomId, $reservation) {
        return Reservation::where('room_id', $roomId)
            ->where(function($query) use ($reservation) {
                $query->whereBetween('from', [$reservation->from, $reservation->to])
                    ->orWhereBetween('to', [$reservation->from, $reservation->to]);
            })->count() > 0;
    }
}
