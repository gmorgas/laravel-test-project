<?php

/**
 * @OA\Schema(schema="ReservationCONFIRMAttributes", required={ "room_id" },
 *
 *  @OA\Property(property="room_id", type="int", example="6"),
 * )
 */

/**
 * @OA\Schema(schema="ReservationCONFIRMDataItem", required={ "type", "attributes", "id" },
 *
 *  @OA\Property(property="type", type="string", example="reservation"),
 *  @OA\Property(property="attributes", type="object", ref="#/components/schemas/ReservationCONFIRMAttributes"   ),
 *  @OA\Property(property="id", type="int", example="4"),
 * )
 **/

/**
 * @OA\Schema(schema="ReservationCONFIRM", required={"data"},
 *
 *  @OA\Property(property="data", type="object", ref="#/components/schemas/ReservationCONFIRMDataItem"   ),
 * )
 **/
