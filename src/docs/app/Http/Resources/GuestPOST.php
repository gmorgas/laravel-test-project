<?php

/**
 * @OA\Schema(schema="GuestPOSTAttributes", required={ "id_number", "first_name", "last_name", "city", "country" },
 *
 *  @OA\Property(property="id_number", type="string", maxLength=30, description="Id number unique", example="ACT456999"),
 *  @OA\Property(property="first_name", type="string", maxLength=100, example="Grzegorz"),
 *  @OA\Property(property="last_name", type="string", maxLength=100, example="Grzegorz"),
 *  @OA\Property(property="email", type="string", format="email", maxLength=100, example="gmail@gmail.com"),
 *  @OA\Property(property="phone", type="string", maxLength=30, example="+4851051061"),
 *  @OA\Property(property="city", type="string", maxLength=100, example="Warszawa"),
 *  @OA\Property(property="country", type="string", minLength=2, maxLength=2, example="PL"),
 * )
 */

/**
 * @OA\Schema(schema="GuestPOSTDataItem", required={ "type", "attributes" },
 *
 *  @OA\Property(property="type", type="string", example="guest"),
 *  @OA\Property(property="attributes", type="object", ref="#/components/schemas/GuestPOSTAttributes"   ),
 * )
 **/

/**
 * @OA\Schema(schema="GuestPOST", required={"data"},
 *
 *  @OA\Property(property="data", type="object", ref="#/components/schemas/GuestPOSTDataItem"   ),
 * )
 **/
