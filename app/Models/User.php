<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use App\Models\UserInfor;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'role_id', 'active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // /**
    // * Get Order of User
    // *
    // * @return \Illuminate\Database\Eloquent\Relations\HasMany
    // */
    // public function orders()
    // {
    //     return $this->hasMany(Order::class, 'user_id', 'id');
    // }

    /**
    * Get Infor of User
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function userInfor()
    {
        return $this->hasOne(UserInfor::class);
    }

    public $sortable = ['username'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

}
