<?php

namespace App\Models\Ticket;

use App\Models\Bus\ScheduleModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingModel extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "booking";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "schedule_id",
        "seat_ids",
        "total_price",
        "payment_type",
        "customer_name",
        "customer_address",
        "customer_mobile",

    ];

    //relation
    public function schedule()
    {
        return $this->belongsTo(ScheduleModel::class,'schedule_id','id');
    }

    public function customer()
    {
        return $this->belongsTo(CustomerModel::class,'customer_id','id');
    }

}
