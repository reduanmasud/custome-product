<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Product extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'price',
        'available',
        'mockup',
        'sku',
        'inventory'
    ];



    /**
     * Get the category that the product belongs to (legacy relationship)
     */
    public function category(){
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the categories that belong to the product
     */
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
