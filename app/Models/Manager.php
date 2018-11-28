<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Manager extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "managers";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'role', 'phone', 'fullname', 'address', 'gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Relationship account t
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function accounts()
    {
        return $this->morphMany(Account::class, 'loginable');
    }

    /**
     * Get all of the posts for the country.
     */
    public function roleResources()
    {
        return $this->hasManyThrough(RoleResource::class, Role::class);
    }
}
