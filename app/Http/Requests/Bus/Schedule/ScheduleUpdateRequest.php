<?php

namespace App\Http\Requests\Bus\Schedule;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "coach_id" => "required|exists:coach,id,deleted_at,NULL",
            "start_route" => "required|string|min:3|different:end_route",
            "end_route" => "required|string|min:3|different:start_route",
            "departure_date" => "required|date|after:yesterday",
            "departure_time" => "required",
            "bus_driver" => "required|string|min:3",
        ];
    }
}
