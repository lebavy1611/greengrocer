<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\CreateCategoryRequest;
use App\Http\Requests\Admin\CreateProductRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $products = Product::with(['shop','category'])->orderBy('created_at', 'desc')->paginate(config('paginate.number_products'));
            $products = $this->formatPaginate($products);
            return $this->showAll($products);
        } catch (Exception $ex) {
            return $this->errorResponse("Product can not be show.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        try {

            $data = $request->only([
                'name', 'shop_id', 'category_id','describe', 'price',
                'origin','quantity', 'active', 'imported_date','expired_date'
            ]);

            $product = Product::create($data);

            $imagesData ="";
            if (is_array(request()->file('image'))) {
                foreach (request()->file('image') as $image) {
                    $newImage = $image->getClientOriginalName();
                    $image->move(public_path(config('define.product.images_path_products')), $newImage);
                    $imagesData[] = [
                        'product_id' => $product->id,
                        'path' => $newImage
                    ];
                }
                $product->images()->createMany($imagesData);
            }

            return $this->successResponse($product, Response::HTTP_OK);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when insert product.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\igration  $igration
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $product = Product::with("category:id,name", "shop:id,name")->findOrFail($id);
            return $this ->successResponse($product, Response::HTTP_OK);
        }catch (ModelNotFoundException $ex){
            return $this ->errorResponse("Product can not be show", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when show Product.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\igration  $igration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->only([
                'name', 'shop_id', 'category_id','describe', 'price',
                'origin','quantity', 'active', 'imported_date','expired_date',
            ]);

            $product = Product::findOrFail($id)->update($data);
            return $this->successResponse("Update product successfully", Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Product not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when show product.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\igration  $igration
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $result = Product::findOrfail($id)->delete();
            return $this->successResponse("Delete product successfully.", Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Product not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when delete product.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
