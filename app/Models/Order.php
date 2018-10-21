<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";
    protected $fillable = [
        'customer_id','address','delivery_time','note','processing_status','payment_status','payment_method_id','coupon_id',
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
    public function payment()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id');
    }

    /**
     * Get the user that owns the phone.
     */
    public function coupon()
    {
        return $this->belongsTo(PaymentMethod::class, 'coupon_id', 'id');
    }
}
