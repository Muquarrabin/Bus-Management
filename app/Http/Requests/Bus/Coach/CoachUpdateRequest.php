<?php

namespace App\Http\Requests\Bus\Coach;

use Illuminate\Foundation\Http\FormRequest;

class CoachUpdateRequest extends FormRequest
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
            "bus_number" => "required|string|min:10|unique:coach,bus_number,".$this->id,
            "bus_seat_quantity" => "required|numeric",
            "coach_type" => "required|string",
        ];
    }
}
