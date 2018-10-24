<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'start_date', 'end_date', 'image'
    ];

    /**
     * Get Category Object
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function promotionDetails()
    {
        return $this->hasMany(PromotionDetail::class, 'promotion_id', 'id');
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
