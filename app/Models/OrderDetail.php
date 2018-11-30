<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = "order_details";
    protected $fillable = [
        'order_id','product_id','quantity'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')
        ->join('images', 'images.product_id' , '=', 'products.id')
        ->select([
            'products.id',
            'products.name',
            'products.price',
            'images.path',

        ]);
    }
}
