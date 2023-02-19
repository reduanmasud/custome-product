<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_variation_id',
        'quantity',
        'total_price',
        'file',
        'bkash_number',
        'trx_id',
        'status',
        'user_id',
    ];


    public function product()
    {
       return $this->belongsTo(Product::class);
    }
}
