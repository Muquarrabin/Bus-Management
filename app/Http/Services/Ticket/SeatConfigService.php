<?php

namespace App\Http\Services\Ticket;

use App\Http\Requests\Ticket\SeatConfig\SeatConfigInsertRequest;
use App\Http\Requests\Ticket\SeatConfig\SeatConfigUpdateRequest;
use App\Models\Ticket\SeatConfigModel;


class SeatConfigService
{
    /**
     * @name mapSeatConfigInsertAttributes
     * @role map request array into custom attribute array
     * @param App\Http\Requests\Ticket\SeatConfig\SeatConfigInsertRequest $request
     * @return Array $attributes
     */
    public function mapSeatConfigInsertAttributes(SeatConfigInsertRequest $request)
    {
        return  [
            "coach_id" => $request->coach_id,
            "seat_type" => $request->seat_type,
            "price" => $request->price,
        ];
    }
    /**
     * @name mapSeatConfigUpdateAttributes
     * @role map request array into custom attribute array
     * @param App\Http\Requests\Ticket\SeatConfig\SeatConfigUpdateRequest $request
     * @return Array $attributes
     */
    public function mapSeatConfigUpdateAttributes(SeatConfigUpdateRequest $request)
    {
        return  [
            "coach_id" => $request->coach_id,
            "seat_type" => $request->seat_type,
            "price" => $request->price,
        ];
    }

    /**
     * @name insertSeatConfig
     * @role insert seat config info
     * @param App\Http\Requests\Ticket\SeatConfig\SeatConfigInsertRequest $request
     * @return status code
     */
    public function insertSeatConfig(SeatConfigInsertRequest $request)
    {
       $seat_type_attributes = $this->mapSeatConfigInsertAttributes($request);

        $seatConfig = SeatConfigModel::create($seat_type_attributes);

        if (!$seatConfig)
            return 500;

        return 201;
    }

    /**
     * @name updateSeatConfig
     * @role update seat config
     * @param  App\Http\Requests\Ticket\SeatConfig\SeatConfigUpdateRequest $request
     * @return status code
     */
    public function updateSeatConfig(SeatConfigUpdateRequest $request, SeatConfigModel $seat_config)
    {
        $attributes = $this->mapSeatConfigUpdateAttributes($request);
        $response = $seat_config->update($attributes);
        if ($response)
            return 200;
        return 500;
    }
}
