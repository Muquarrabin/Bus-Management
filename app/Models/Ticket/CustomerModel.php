<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerModel extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = "customer";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "customer_name",
        "customer_address",
        "customer_mobile",

    ];

    //relation


    public function booking()
    {
        return $this->hasMany(BookingModel::class,'customer_id','id');
    }

}
