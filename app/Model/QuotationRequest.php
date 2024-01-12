<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationRequest extends Model
{
    use HasFactory;
    protected $table = 'quotation_contact';
    protected $guarded = ['id'];
    public $timestamps = false;

   /* public function customer()
    {
        return $this->belongsTo('App\User','customer_id');
    }*/
}
