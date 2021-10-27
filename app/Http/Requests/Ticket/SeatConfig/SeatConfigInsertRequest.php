<?php

namespace App\Http\Requests\Ticket\SeatConfig;

use Illuminate\Foundation\Http\FormRequest;

class SeatConfigInsertRequest extends FormRequest
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
            "seat_type" => "required",
            "price" => "required|numeric",
        ];
    }
}
