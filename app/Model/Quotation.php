<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $table = 'quotations';
   protected $guarded = ['id'];
    /*protected $fillable =[

        "reference_no", "user_id", "customer_id","total_item", "total_qty", "total_discount","total_vat",
        "total_tax", "total_price", "order_tax_rate", "order_tax", "order_discount",  "grand_total","quotation_status","document",
        "note","subject", "shipping_vat","shipping_amount","shipping_cost","shipping_description",
    ];*/

    public function customer()
    {
        return $this->belongsTo('App\User','customer_id');
    }

    public function productQuotations() {
        return $this->hasMany(ProductQuotation::class,'quotation_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class,'user_id');
    }
}
