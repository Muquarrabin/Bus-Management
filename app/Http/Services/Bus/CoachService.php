<?php

namespace App\Http\Services\Bus;

use App\Models\Bus\CoachModel;
use Illuminate\Http\Request;

class CoachService
{
    /**
     * @name mapCoachInsertAttributes
     * @role map request array into custom attribute array
     * @param Illuminate\Http\Request $request
     * @return Array $attributes
     *
     */
    public function mapCoachInsertAttributes(Request $request)
    {
        return  [
            "bus_number" => $request->bus_number,
            "bus_seat_quantity" => $request->bus_seat_quantity,
            "coach_type" => $request->coach_type,
        ];
    }
    /**
     * @name mapCoachUpdateAttributes
     * @role map request array into custom attribute array
     * @param Illuminate\Http\Request $request
     * @return Array $attributes
     *
     */
    public function mapCoachUpdateAttributes(Request $request)
    {
        return  [
            "bus_number" => $request->bus_number,
            "bus_seat_quantity" => $request->bus_seat_quantity,
            "coach_type" => $request->coach_type,
        ];
    }

    /**
     * @name validateCoachInsert
     * Validate the coach insert request.
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateCoachInsert(Request $request)
    {
        $request->validate(
            CoachModel::$insertRules
        );
    }

    /**
     * @name validateCoachUpdate
     * Validate the coach update request.
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateCoachUpdate(Request $request)
    {
        $request->validate(
            CoachModel::$updateRules
        );
    }

     /**
     * @name insertCoach
     * @role insert coach info
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\Bus\CoachModel
     */
    public function insertCoach(Request $request)
    {
        $coach_attributes=$this->mapCoachInsertAttributes($request);

        $coachInfo=CoachModel::create($coach_attributes);

        return $coachInfo;
    }
}
