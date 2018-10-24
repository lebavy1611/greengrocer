<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = "coupons";
    protected $fillable = [
        'code', 'percents', 'start_date', 'end_date', 'times'
    ];

}
