<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
    use SoftDeletes;

    protected $table = "ratings";
    protected $fillable = [
        'product_id','customer_id','stars','content'
    ];

    /**
     * Get the user that owns the phone.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id')
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
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
