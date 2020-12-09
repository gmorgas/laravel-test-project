<?php

/**
 * @OA\Schema(schema="ReservationCOMPLETEDDataItem", required={ "type", "id" },
 *
 *  @OA\Property(property="type", type="string", example="reservation"),
 *  @OA\Property(property="id", type="int", example="4"),
 * )
 **/

/**
 * @OA\Schema(schema="ReservationCOMPLETED", required={"data"},
 *
 *  @OA\Property(property="data", type="object", ref="#/components/schemas/ReservationCOMPLETEDDataItem"   ),
 * )
 **/
