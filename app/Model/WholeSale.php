<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WholeSale extends Model
{
    use HasFactory;
    protected $table = 'wholesale_prices';
    protected $fillable =[

        "product_stock_id", "min_qty", "max_qty", "price"
    ];
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
