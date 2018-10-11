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
        if ($request->newest_products) {
            return $query->orderBy('created_at', 'desc')->limit($request->newest_products);
        }
        if ($request->filter) {
            $filter = $request->filter;
            if ($filter == 'hotest') {
                return $query->join('categories', function ($join) {
                    $join->on('categories.id', '=', 'products.category_id');
                })
                ->select('products.*')
                ->where('categories.parent_id', $id)->take(config('define.limit_row_slide'));
            }
        }
        if ($request->category_id) {
            if (isset($request->page)) {
                return $query->join('categories', function ($join) {
                    $join->on('categories.id', '=', 'products.category_id');
                })
                ->select('products.*')
                ->where('categories.parent_id', $request->category_id)
                ->orWhere('products.category_id', $request->category_id);
            }
        }
        if ($request->name) {
            return $query->where('name', 'like', '%'.$request->name.'%');
        }
    }
}
