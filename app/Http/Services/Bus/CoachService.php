<?php

namespace App\Http\Services\Bus;

use App\Http\Requests\Bus\Coach\CoachInsertRequest;
use App\Http\Requests\Bus\Coach\CoachUpdateRequest;
use App\Models\Bus\CoachModel;
use Illuminate\Http\Request;

class CoachService
{
    /**
     * @name mapCoachInsertAttributes
     * @role map request array into custom attribute array
     * @param App\Http\Requests\Bus\Coach\CoachInsertRequest $request
     * @return Array $attributes
     *
     */
    public function mapCoachInsertAttributes(CoachInsertRequest $request)
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
     * @param App\Http\Requests\Bus\Coach\CoachUpdateRequest $request
     * @return Array $attributes
     *
     */
    public function mapCoachUpdateAttributes(CoachUpdateRequest $request)
    {
        return  [
            "bus_number" => $request->bus_number,
            "bus_seat_quantity" => $request->bus_seat_quantity,
            "coach_type" => $request->coach_type,
        ];
    }


     /**
     * @name insertCoach
     * @role insert coach info
     * @param  App\Http\Requests\Bus\Coach\CoachInsertRequest $request
     * @return \App\Models\Bus\CoachModel
     */
    public function insertCoach(CoachInsertRequest $request)
    {
        $coach_attributes=$this->mapCoachInsertAttributes($request);

        $coachInfo=CoachModel::create($coach_attributes);

        return $coachInfo;
    }
     /**
     * @name updateCoach
     * @role update coach info
     * @param  App\Http\Requests\Bus\Coach\CoachUpdateRequest $request
     * @return \App\Models\Bus\CoachModel
     */
    public function updateCoach(CoachUpdateRequest $request,CoachModel $coach)
    {
        try {
            $attributes = $this->mapCoachUpdateAttributes($request);
            $response = $coach->update($attributes);
            return $response;
        } catch (\Throwable $th) {
            //return $this->sendError($th->getMessage(), [], 500);
            throw $th;
        }
    }
}
