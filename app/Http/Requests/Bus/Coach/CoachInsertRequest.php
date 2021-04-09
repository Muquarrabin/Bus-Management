<?php

namespace App\Http\Requests\Bus\Coach;

use Illuminate\Foundation\Http\FormRequest;

class CoachInsertRequest extends FormRequest
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
            "bus_number" => "required|string|unique:coach|min:10",
            "bus_seat_quantity" => "required|numeric",
            "coach_type" => "required|string",
        ];
    }
}
