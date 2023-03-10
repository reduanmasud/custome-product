<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'mockup'
    ];



    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }
}
