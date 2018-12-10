<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleResource extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "role_resources";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'resource_id', 'can_view', 'can_add', 'can_edit', 'can_del'
    ];

    /**
     * Get the role.
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    /**
     * Get the resource.
     */
    public function resource()
    {
        return $this->belongsTo(Resource::class, 'resource_id', 'id');
    }

}
