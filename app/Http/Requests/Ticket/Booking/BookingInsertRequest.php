<?php

namespace App\Http\Requests\Ticket\Booking;

use Illuminate\Foundation\Http\FormRequest;

class BookingInsertRequest extends FormRequest
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
            "schedule_id" => "required|exists:schedule,id,deleted_at,NULL",
            "customer_name" => "required",
            "customer_address" => "required",
            "customer_mobile" => "required",
            "total_price" => "required",
            "seat_ids" => "required",
            "unit_price" => "required",
            "payment_type" => "required",
        ];
    }
}
