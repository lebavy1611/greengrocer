<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Http\Requests\Admin\CreateProductController;
use App\Models\Product;
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
        //\DB::enableQueryLog();
            //$products = Product::with('category.parent', 'shop', 'images')->filter($request)->orderBy('created_at', 'desc')->paginate(config('paginate.number_products'));
            $products = Product::with('category.parent', 'shop', 'images')->product($request)->orderBy('created_at', 'desc')->paginate($number_products);
            $products = $this->formatPaginate($products);
            //dd(\DB::getQueryLog());
            return $this->showAll($products, Response::HTTP_OK);
            //return $this->showAll($products);
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
            $product = Product::with("category:id,name", "shop:id,name", 'images', 'comments', 'ratings')->findOrFail($id);
            return $this ->successResponse($product, Response::HTTP_OK);
        }catch (ModelNotFoundException $ex){
            return $this ->errorResponse("Product can not be show", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when show Product.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
