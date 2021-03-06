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
        $products = Product::with('shop.provider','category.parent', 'images')->productFilter($request)
            ->where('active', 1)->orderBy('created_at', 'desc')->get();
        foreach ($products as $key => $product) {
            if ($product->ratings->count()) {
                $product['avg_ratings'] = $product->ratings->sum('stars') / $product->ratings->count();
            } else {
                $product['avg_ratings'] = 0;
            }
        }
        $data = $products->toArray();
        array_walk($data, function(&$product, $key) {
            $collection = collect($product['images']);
            $product['images'] = $collection->pluck('path')->toArray();
        });
        return $this->showAll($this->formatPaginate($this->paginate(collect($data))), Response::HTTP_OK);
    }

    /**
    * Display the specified resource.
    *
    * @param int $id id

    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $product = Product::with("category:id,name", "shop:id,name", 'images', 'comments.user.userInfor')
            ->where('active', 1)->findOrFail($id);
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
