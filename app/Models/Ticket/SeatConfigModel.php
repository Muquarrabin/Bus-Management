<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Bus\CoachModel;

class SeatConfigModel extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "seat_config";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "coach_id",
        "seat_type",
        "price",

    ];

    //relation
    public function coach()
    {
        return $this->belongsTo(CoachModel::class,'coach_id','id');
    }
}
