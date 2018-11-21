<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use App\Models\UserInfor;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\FilterTrait;

class Account extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens, FilterTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "accounts";

    protected $guarded = [];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Loginable polimophic relationship
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphTo morphTo
     */
    public function loginable()
    {
         return $this->morphTo();
    }
}
