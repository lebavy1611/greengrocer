<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Interfaces\StatisticInterface;

class Product extends Model implements StatisticInterface
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
    }

    public function getName()
    {
        return $this->DB::table(comments)
            ->join('users', 'users.id' , '=', 'comments.customer_id')
            ->join('user_infors', 'user_infors.user_id' , '=', 'users.id')
            ->select([
                'users.id',
                'user_infors.fullname',
                'user_infors.address',
                'user_infors.phone',
            ]);
    }

    /**
     * Get the user that owns the phone.
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'product_id', 'id');
    }

    /**
     * Get the images path that product.
     */
    public function pathImages()
    {
        return $this->images()->select('id', 'path');
    }

    /**
     * The promotions that belong to the product.
     */
    public function promotions()
    {
        return $this->belongsToMany(Promotion::class, 'promotion_details', 'product_id', 'promotion_id');
    }

    /**
     * Get Category Object
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function promotionDetails()
    {
        return $this->hasMany(PromotionDetail::class, 'promotion_id', 'id');
    }

    public function count($conditions = []) 
    {
        if ($conditions) {
            return Product::where($conditions)->count();
        }
        return Product::all()->count();
    }
}
