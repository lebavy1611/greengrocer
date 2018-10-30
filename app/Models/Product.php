<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, FilterTrait;

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

    /**
     * Get the user that owns the phone.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'product_id', 'id');
//            ->join('users', 'users.id' , '=', 'comments.customer_id')
//            ->join('user_infors', 'user_infors.user_id' , '=', 'users.id')
//            ->select([
//                'users.id',
//                'user_infors.fullname',
//                'user_infors.address',
//                'user_infors.phone',
//            ]);
    }

    /**
     * Get the user that owns the phone.
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'product_id', 'id');
    }
}
