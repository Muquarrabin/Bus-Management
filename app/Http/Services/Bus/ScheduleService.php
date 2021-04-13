<?php

namespace App\Http\Services\Bus;

use App\Http\Requests\Bus\Schedule\ScheduleInsertRequest;
use App\Http\Requests\Bus\Schedule\ScheduleUpdateRequest;
use App\Models\Bus\ScheduleModel;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ScheduleService
{
    /**
     * @name mapScheduleInsertAttributes
     * @role map request array into custom attribute array
     * @param App\Http\Requests\Bus\Schedule\ScheduleInsertRequest $request
     * @return Array $attributes
     */
    public function mapScheduleInsertAttributes(ScheduleInsertRequest $request)
    {
        return  [
            "coach_id" => $request->coach_id,
            "start_route" => $request->start_route,
            "end_route" => $request->end_route,
            "departure_date" => $request->departure_date,
            "departure_time" => $request->departure_time,
            "bus_driver" => $request->bus_driver,
        ];
    }
    /**
     * @name mapScheduleUpdateAttributes
     * @role map request array into custom attribute array
     * @param App\Http\Requests\Bus\Schedule\ScheduleUpdateRequest;
     * @return Array $attributes
     *
     */
    public function mapScheduleUpdateAttributes(ScheduleUpdateRequest $request)
    {
        return  [
            "coach_id" => $request->coach_id,
            "start_route" => $request->start_route,
            "end_route" => $request->end_route,
            "departure_date" => $request->departure_date,
            "departure_time" => $request->departure_time,
            "bus_driver" => $request->bus_driver,
        ];
    }


    /**
     * @name insertSchedule
     * @role insert schedule info
     * @param App\Http\Requests\Bus\Schedule\ScheduleInsertRequest $request
     * @return status code
     */
    public function insertSchedule(ScheduleInsertRequest $request)
    {
        $request->departure_date = date('Y-m-d', strtotime($request->departure_date));
        $request->departure_time = date('H:i:s', strtotime($request->departure_time));

        $bus_info = new ScheduleModel();
        $bus_info->departure_date = $request->departure_date;
        $bus_info->departure_time = $request->departure_time;
        $bus_info->coach_id = $request->coach_id;

        $isBusAvailable = $this->scheduleAvailabilityForInsert($bus_info);

        if ($isBusAvailable)
            return 409;

        $schedule_attributes = $this->mapScheduleInsertAttributes($request);

        $scheduleInfo = ScheduleModel::create($schedule_attributes);

        if (!$scheduleInfo)
            return 500;

        return 201;
    }

    public function scheduleAvailabilityForInsert(ScheduleModel $scheduleInfo)
    {
        $coachScheduleInfo = ScheduleModel::where('coach_id', '=', $scheduleInfo->coach_id)
            ->where('departure_date', '=', $scheduleInfo->departure_date)->get();

        foreach ($coachScheduleInfo as $coachInfo) {

            $start_time = Carbon::parse($coachInfo->departure_time);
            $end_time = Carbon::parse($scheduleInfo->departure_time);
            $timeDiff = $start_time->diffInHours($end_time);
            if ($timeDiff < 3 )
                return true;
        }
        return false;
    }
    public function scheduleAvailabilityForUpdate(ScheduleModel $scheduleInfo)
    {
        $coachScheduleInfo = ScheduleModel::where('coach_id', '=', $scheduleInfo->coach_id)
            ->where('departure_date', '=', $scheduleInfo->departure_date)->get();

        foreach ($coachScheduleInfo as $coachInfo) {

            $start_time = Carbon::parse($coachInfo->departure_time);
            $end_time = Carbon::parse($scheduleInfo->departure_time);
            $timeDiff = $start_time->diffInHours($end_time);
            if ($timeDiff < 3 && !($coachInfo->departure_time==$scheduleInfo->departure_time))
                return true;
        }
        return false;
    }
    /**
     * @name updateSchedule
     * @role update schedule info
     * @param  App\Http\Requests\Bus\Schedule\ScheduleUpdateRequest $request
     * @param  App\Models\Bus\ScheduleModel $schedule
     * @return status code
     */
    public function updateSchedule(ScheduleUpdateRequest $request, ScheduleModel $schedule)
    {
        $request->departure_date = date('Y-m-d', strtotime($request->departure_date));
        $request->departure_time = date('H:i:s', strtotime($request->departure_time));
        // dd($request->departure_date);
        $bus_info = new ScheduleModel();
        $bus_info->departure_date = $request->departure_date;
        $bus_info->departure_time = $request->departure_time;
        $bus_info->coach_id = $request->coach_id;

        $isBusAvailable = $this->scheduleAvailabilityForUpdate($bus_info);

        if ($isBusAvailable)
            return 409;
        $attributes = $this->mapScheduleUpdateAttributes($request);
        $response = $schedule->update($attributes);
        if ($response)
            return 200;
        return 500;
    }
}
