<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
    ];


    /**
     * Get the products that belong to the category (legacy relationship)
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the products that belong to the category using many-to-many relationship
     */
    public function productsMany()
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * Alias for productsMany to match the Product model's method
     */
    public function products_many()
    {
        return $this->productsMany();
    }
}
