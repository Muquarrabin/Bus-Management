<?php

namespace App\Models\Bus;

use App\Models\Ticket\SeatConfigModel;
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


    //relation
    public function schedule()
    {
        return $this->hasMany(ScheduleModel::class,'coach_id','id');
    }
    public function seatConfig()
    {
        return $this->hasMany(SeatConfigModel::class,'coach_id','id');
    }

}
