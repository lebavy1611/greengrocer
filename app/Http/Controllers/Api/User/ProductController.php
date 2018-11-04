<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Http\Requests\Admin\CreateProductController;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Promotion;

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
            $products = Product::with('shop.inforProvider','category.parent', 'images')->productFilter($request)
                ->where('active', 1)->orderBy('created_at', 'desc')->paginate($number_products);
            $products = $this->formatPaginate($products);
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
        try{
            $product = Product::with("category:id,name", "shop.inforProvider", 'images', 'ratings')
                ->where('active', 1)->findOrFail($id);
            $comments = Comment::with('user.userInfor')->where('product_id', $id)->get();
            $product['comments'] = $comments;
            return $this ->successResponse($product, Response::HTTP_OK);
        }catch (ModelNotFoundException $ex){
            return $this ->errorResponse("Product can not be show", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return $this->errorResponse("Occour error when show Product.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
