<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestCallBack extends Model
{
    use HasFactory;
    protected $table = 'request_call_back';

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
