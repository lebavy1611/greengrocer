<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\CreateProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use App\Services\UploadImageService;

class ProductController extends ApiController
{
    protected $uploadImageService;

    /**
     * CategoryController constructor..
     *
     * @param UploadImageService   $uploadImageService   UploadImageService
     */
    public function __construct(UploadImageService $uploadImageService)
    {
        $this->uploadImageService = $uploadImageService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $products = Product::with('category.parent', 'shop.provider', 'images')->productFilter($request)
                ->orderBy('created_at', 'desc')->paginate(config('paginate.number_products'));
            $products = $this->formatPaginate($products);
            return $this->showAll($products, Response::HTTP_OK);
        } catch (Exception $ex) {
            dd($ex->getMessage());
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
                'origin','quantity','number_expired'
            ]);

            $data['imported_date'] = Carbon::now();
            $data['expired_date'] = Carbon::now()->addDay($data['number_expired']);
            unset($data['number_expired']);

            $product = Product::create($data);

            $imagesData = [];
            if ($request->hasFile('images')) {
                $imagesData = $this->uploadImageService->multiFilesUpload($request, 'products',  $product);
                $product->images()->createMany($imagesData);
            }
            return $this->successResponse($product->load('images'), Response::HTTP_OK);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return $this->errorResponse("Có lỗi xảy ra.", Response::HTTP_INTERNAL_SERVER_ERROR);
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
            $product = Product::with("category:id,name", "shop.provider", 'images')->findOrFail($id);
            $comments = Comment::with('user.userInfor')->where('product_id', $id)->get();
            $ratings = Rating::all()->where('product_id', $id);

            $total = 0;
            $stars = 0;
            foreach ($ratings as $rating) {
                $stars += $rating->stars;
                $total +=1;
            }
            if($total != 0)
            $stars = round($stars/$total);

            $product['ratings']= array("avg"=>$stars ,"total"=>$total, "list"=> $ratings);

            $product['comments'] = $comments;
            return $this ->successResponse($product, Response::HTTP_OK);
        }catch (ModelNotFoundException $ex){
            return $this ->errorResponse("Sản phẩm không tồn tại", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return $this->errorResponse("Có lỗi xảy ra.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\igration  $igration
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $data = $request->only([
                'name', 'shop_id', 'category_id','describe', 'price',
                'origin','quantity', 'active', 'number_expired'
            ]);

            if ($data['number_expired']) {
                $data['imported_date'] = Carbon::now();
                $data['expired_date'] = Carbon::now()->addDay($data['number_expired']);
            }
            unset($data['number_expired']);

            $product->update($data);
            $imagesData = [];
            if ($request->hasFile('images')) {
                $imagesData = $this->uploadImageService->multiFilesUpload($request, 'products',  $product);
                $product->images()->createMany($imagesData);
            }
            return $this->successResponse($product->load('images'), Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Không tìm thấy sản phẩm", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return $this->errorResponse("Có lỗi xảy ra.", Response::HTTP_INTERNAL_SERVER_ERROR);
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
            Product::findOrfail($id)->delete();
            return $this->successResponse("Xóa sản phẩm thành công.", Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Sản phẩm không tồn tại", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Có lỗi xảy ra.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
