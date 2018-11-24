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

        if ($request->name) {
            $query->where('products.name', 'like', '%' . $request->name . '%');
        }

        if ($request->category_id) {
            $query->join('categories', function ($join) {
                $join->on('categories.id', '=', 'products.category_id');
            })->where(function ($q) use ($request) {
                return $q->where('categories.parent_id', $request->category_id)
                    ->orWhere('products.category_id', $request->category_id);
            });
        }

        if ($request->shop_id) {
             $query->join('shops', function ($join) {
                $join->on('shops.id', '=', 'products.shop_id');
            })->where(function ($q) use ($request) {
                 return $q->where('products.shop_id', $request->shop_id);
            });
        }

        if ($request->origin) {
            $query->where(function ($q) use ($request) {
                return $q->where('origin', 'like', '%'.$request->origin.'%');
            });
        }

        if ($request->imported_date) {
            $query->where(function ($q) use ($request) {
                return $q->where('imported_date', 'like', '%'.$request->imported_date.'%');
            });
        }

        return $query->select('products.*');

    }


    public function scopeOrderFilter($query, Request $request)
    {

        if ($request->customer_id) {
            $query->join('users', function ($join) {
                $join->on('users.id', '=', 'orders.customer_id');
            })
                ->where('orders.customer_id', $request->customer_id);

        }

        if ($request->processing_status) {
            $query->where(function ($q) use ($request) {
                return $q->where('orders.processing_status', $request->processing_status);
            });
        }

        if ($request->payment_status) {
            $query->where(function ($q) use ($request) {
                return $q->where('orders.payment_status', $request->payment_status);
            });
        }

        if ($request->payment_method_id) {
            $query->where(function ($q) use ($request) {
                return $q->where('orders.payment_method_id', $request->payment_method_id);
            });
        }

        return $query->select('orders.*');

    }
}
