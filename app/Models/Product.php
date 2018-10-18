<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";

    protected $fillable = [
        'name', 'shop_id', 'category_id','describe', 'price',
        'origin','quantity', 'active', 'imported_date','expired_date'
    ];

    /**
     * Get the user that owns the phone.
     */
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    /**
     * Get the user that owns the phone.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * Get the user that owns the phone.
     */
    public function images()
    {
        return $this->hasMany(Image::class, 'product_id', 'id');
    }
}
