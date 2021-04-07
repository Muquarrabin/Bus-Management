<?php

namespace App\Models\Bus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoachModel extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "coach";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "bus_number",
        "bus_seat_quantity",
        "coach_type",
    ];

    /**
     * Insert Vaildation Rules
     *
     * @var array
     */
    public static $insertRules = [
        "bus_number" => "required|string|unique:coach|min:10",
        "bus_seat_quantity" => "required|numeric",
        "coach_type" => "required|string",
    ];

    /**
     * update Vaildation Rules
     *
     * @var array
     */
    public static $updateRules = [
        "bus_number" => "required|string|unique:coach|min:10",
        "bus_seat_quantity" => "required|numeric",
        "coach_type" => "required|string",
    ];
}
