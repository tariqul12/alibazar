<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductQuotation extends Model
{
    use HasFactory;
    protected $table = 'product_quotation';
    protected $fillable =[

        "quotation_id", "product_id", "qty", "net_unit_price", "discount", "tax", "total","name","code","description","vat","vat_rate","single_unit_price_vat","single_unit_vat"
    ];
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
