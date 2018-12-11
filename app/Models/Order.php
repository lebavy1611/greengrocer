<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\SoftDeletes;


class Order extends Model
{
    use FilterTrait, SoftDeletes;

    const STATUS_PAYED = 1;             //da thanh toan

    const STATUS_NOT_PAYED = 2;         //chua thanh toan

    const PAYMENT_ON_DELIVERY = 1;      //thanh toan khi nhan hang

    const STATUS_PROCESSING = 1;        //dang xu ly

    const CANCEL_STATUS_PROCESSING = 21; //huy order


    protected $table = "orders";
    protected $fillable = [
        'customer_id','full_name','phone', 'address','delivery_time','note','processing_status',
        'payment_status','payment_method_id','coupon_id',
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
    public function getPaymentStatusAttribute()
    {
        return $this->attributes['payment_status'] == self::STATUS_PAYED ? 'Đã thanh toán' : 'Chưa thanh toán';
    }

    /**
     * Get the user that owns the phone.
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id', 'id');
    }

    /**
     * Get OrderDetail for Order, the name's function isn't the Camel, because Kyslik\ColumnSortable\Sortable
     * doesn't allow the Camel when using withCount().
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderdetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    /**
     * Get the user that owns the phone.
     */
    public function processStatus()
    {
        return $this->belongsTo(ProcessStatus::class, 'processing_status', 'id');
    }

    /**
     * Get the user that owns the phone.
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id')->select('name');
    }

}
