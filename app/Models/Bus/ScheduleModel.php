<?php

namespace App\Models\Bus;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScheduleModel extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "schedule";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "coach_id",
        "start_route",
        "end_route",
        "departure_date",
        "departure_time",
        "bus_driver"
    ];

    //relation
    public function coach()
    {
        return $this->belongsTo(CoachModel::class,'coach_id','id');
    }
}
