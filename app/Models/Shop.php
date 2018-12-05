<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Interfaces\StatisticInterface;

class Shop extends Model implements StatisticInterface
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'provider_id', 'address', 'phone', 'image', 'active'
    ];

    /**
     * Get Category Object
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provider()
    {
        return $this->belongsTo(Manager::class, 'provider_id', 'id');
    }

    /**
     * Get Products of Store
     *
     * @return array
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'shop_id', 'id');
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function count($conditions = []) 
    {
        if ($conditions) {
            return Shop::where($conditions)->count();
        }
        return Shop::all()->count();
    }
}
