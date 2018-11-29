<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Http\Requests\Admin\CreateProductController;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Promotion;
use App\Models\Rating;

class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $number_products = isset($request->number_products) ? $request->number_products : config('paginate.number_products');
        $products = Product::with('shop.provider','category.parent', 'images')->productFilter($request)
            ->where('active', 1)->orderBy('created_at', 'desc')->paginate($number_products);
        $products = $this->formatPaginate($products);
        $data = $products['data'];
        array_walk($data, function(&$product, $key) {
            $collection = collect($product['images']);
            $product['images'] = $collection->pluck('path')->toArray();
        });
        $products['data'] = $data;
        return $this->showAll($products, Response::HTTP_OK);
    }

    /**
    * Display the specified resource.
    *
    * @param int $id id

    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $product = Product::with("category:id,name", "shop:id,name", 'images', 'comments.user:users.id,user_infors.fullname')
            ->where('active', 1)->findOrFail($id)->findOrFail($id);
        $comments = Comment::with('user.userInfor')->where('product_id', $id)->get();
        $product['comments'] = $comments;

        $ratings = Rating::with('user:users.id,user_infors.fullname')->where('product_id', $id)->get();
        $images = $product['images']->pluck('path')->toArray();
        unset($product['images']);
        $product['images'] = $images;
        $total = 0;
        $stars = 0;
        if (count($ratings)) {
            foreach ($ratings as $rating) {
                $stars += $rating->stars;
                $total +=1;
            }
            $stars = round($stars/$total);
        }
        $product['ratings']= array("avg"=>$stars ,"total"=>$total, "list"=> $ratings);
        return $this ->successResponse($product, Response::HTTP_OK);
    }
}
