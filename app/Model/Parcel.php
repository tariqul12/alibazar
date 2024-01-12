<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    use HasFactory;
    protected $table = 'parcels';
    protected $guarded = 'id';

    public function order() {
        return $this->belongsTo(Order::class,'order_id','id');
    }
}
