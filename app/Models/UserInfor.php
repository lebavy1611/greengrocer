<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserInfor extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'fullname', 'birthday', 'avatar', 'address', 'phone', 'gender',
    ];

    /**
    * Get Infor of User
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
