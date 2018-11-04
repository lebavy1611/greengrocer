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
    public function scopeProductFilter($query, Request $request, $id = 0)
    {
        if ($request->role) {
            return $query->where('role_id', $request->role == 'customer'?1:2);
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
            if ($filter == 'newest') {
                return $query->orderBy('created_at', 'desc');
            }
        }
        if ($request->category_id) {
            return $query->join('categories', function ($join) {
                $join->on('categories.id', '=', 'products.category_id');
            })
            ->select('products.*')
            ->where('categories.parent_id', $request->category_id)
            ->orWhere('products.category_id', $request->category_id);

        }
        if ($request->promotion_id) {
            $query->whereIn('id', function ($query) use ($request) {
                $query->select('product_id')
                        ->from('promotion_details')
                        ->where('promotion_id', $request->promotion_id);
            });
        }
        if ($request->name) {
            return $query->where('name', 'like', '%'.$request->name.'%');
        }
    }


    public function scopeCategoryFilter($query, Request $request)
    {
        if ($request->name) {
            return $query->where('name', 'like', '%'.$request->name.'%');
        }
    }


    public function scopeOrderFilter($query, Request $request)
    {

        if ($request->customer_id) {
            return $query->join('users', function ($join) {
                $join->on('users.id', '=', 'orders.customer_id');
            })
                ->where('orders.customer_id', $request->customer_id)
                ->select('orders.*');

        }

        if ($request->processing_status) {
            return $query->where('orders.processing_status', $request->processing_status);
        }

        if ($request->payment_status) {
            return $query->where('orders.payment_status', $request->payment_status);
        }

        if ($request->payment_method_id) {
            return $query->where('orders.payment_method_id', $request->payment_method_id);
        }

    }
}
