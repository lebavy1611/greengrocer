<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\UserInfor;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Interfaces\StatisticInterface;

class User extends Model implements StatisticInterface
{
    use SoftDeletes, FilterTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'active',
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

    /**
     * User has one account via loginable
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany MorphMany
     */
    public function accounts()
    {
        return $this->morphMany(Account::class, 'loginable')->select('id', 'email', 'loginable_id', 'loginable_type');
    }

    public function count($conditions = []) 
    {
        if ($conditions) {
            return User::where($conditions)->count();
        }
        return User::all()->count();
    }
}
