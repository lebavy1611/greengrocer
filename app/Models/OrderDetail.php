<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use SoftDeletes;

    protected $table = "order_details";
    protected $fillable = [
        'order_id','product_id','quantity', 'price'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')
        ->select([
            'products.id',
            'products.name',
            'products.price',
            'products.shop_id'
        ]);
    }
}
