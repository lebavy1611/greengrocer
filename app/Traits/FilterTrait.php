<?php
namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\Category;

trait FilterTrait
{
    /**
     * Filter with request data
     *
     * @param \Illuminate\Database\Eloquent\Builder|static $query   query
     * @param \Illuminate\Http\Request                     $request request
     * @param int                                          $id      id
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function scopeFilter($query, Request $request, $id = 0)
    {
        if ($request->role) {
            return $query->where('role_id', $request->role == 'customer'?1:2);
        }
    }
}
