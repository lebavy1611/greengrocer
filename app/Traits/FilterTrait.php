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

        if ($request->keyword) {
            $query->join('categories', function ($join) {
                $join->on('categories.id', '=', 'products.catgory_id');
            })->join('shop', function ($join) {
                $join->on('users.id', '=', 'user_infors.user_id');
            })->orWhere('orders.code', 'like', '%' . $request->keyword . '%')
            ->orWhere('orders.full_name', 'like', '%' . $request->keyword . '%');
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

        if ($request->price) {
            $query->orderBy('price', $request->price);
        }

        return $query->select('products.*');

    }


    public function scopeOrderFilter($query, Request $request)
    {
        if ($request->keyword) {
            $query->join('users', function ($join) {
                $join->on('users.id', '=', 'orders.customer_id');
            })->join('user_infors', function ($join) {
                $join->on('users.id', '=', 'user_infors.user_id');
            })->orWhere('orders.code', 'like', '%' . $request->keyword . '%')
            ->orWhere('orders.full_name', 'like', '%' . $request->keyword . '%')
            ->orWhere('orders.phone', 'like', '%' . $request->keyword . '%')
            ->orWhere('orders.address', 'like', '%' . $request->keyword . '%')
            ->orWhere('orders.note', 'like', '%' . $request->keyword . '%')
            ->orWhere('user_infors.fullname', 'like', '%' . $request->keyword . '%')
            ->orWhere('users.email', 'like', '%' . $request->keyword . '%')
            ->orWhere('users.username', 'like', '%' . $request->keyword . '%')
            ->orWhere('user_infors.address', 'like', '%' . $request->keyword . '%');
        }
        if ($request->shop_id) {
            $query->join('order_details', function ($join) {
                $join->on('orders.id', '=', 'order_details.order_id');
            })->join('products', function ($join) {
                $join->on('products.id', '=', 'order_details.product_id');
            })->join('shops', function ($join) {
                $join->on('shops.id', '=', 'products.shop_id');
            })->where('shops.id', $request->shop_id);

        }
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

    public function scopeManagerFilter($query, Request $request)
    {
        if ($request->role) {
            $query->where(function ($q) use ($request) {
                return $q->where('managers.role', $request->role);
            });
        }
        return $query->select('managers.*');

    }

    public function scopeUserFilter($query, Request $request)
    {
        return $query->select('users.*');

    }
}
