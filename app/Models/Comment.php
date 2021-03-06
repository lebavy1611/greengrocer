<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    
    protected $table = "comments";
    protected $fillable = [
        'product_id','customer_id','parent_id','content'
    ];

    public function inforUser()
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

    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }


    /**
     * Get the user that owns the phone.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }

}
