<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'name',
        'category_id',
        'description',
        'weight',
        'price',
        'stock'
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function detail_transactions()
    {
        return $this->hasMany(DetailTransaction::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
