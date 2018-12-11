<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\CreatePromotionRequest;
use App\Http\Requests\Admin\UpdatePromotionRequest;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use App\Services\UploadImageService;
use App\Models\PromotionDetail;

class PromotionController extends ApiController
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
    public function index()
    {
        try {
            $promotions = Promotion::get();
            return $this->showAll($promotions);
        } catch (Exception $ex) {
            return $this->errorResponse("Promotions can not be show.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePromotionRequest $request)
    {
        try {

            $data = $request->only([
                'name', 'start_date', 'end_date',
            ]);
            $data['image'] = $this->uploadImageService->fileUpload($request, 'promotions', 'image');
            $promotion = Promotion::create($data);
            $products = $request->products;
            $dataDetail = [];
            foreach ($products as $product) {
                $dataDetail[] = [
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                    'percents' => $product['percents']
                ];
            }
            $promotion->promotionDetails()->createMany($dataDetail);
            return $this->successResponse($promotion->load('promotionDetails'), Response::HTTP_OK);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when insert Promotion.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $promotion = Promotion::findOrFail($id);
            return $this->successResponse($promotion->load('promotionDetails.product'), Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Promotion not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when show Promotion.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePromotionRequest $request, $id)
    {
        try {
            $data = $request->only([
                'name', 'start_date', 'end_date', 'image',
            ]);
            if ($request->hasFile('image')) {
                $data['image'] = $this->uploadImageService->fileUpload($request, 'promotions', 'image');
            }
            $promotion = Promotion::findOrFail($id);
            $promotion->update($data);
            $promotion->promotionDetails()->forceDelete();
            $products = $request->products;
            $dataDetail = [];
            foreach ($products as $product) {
                $dataDetail[] = [
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                    'percents' => $product['percents']
                ];
            }
            $promotion->promotionDetails()->createMany($dataDetail);
            return $this->successResponse("Update promotion successfully", Response::HTTP_OK);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when edit Promotion.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promotion $promotion)
    {
        try {
            $promotion->promotionDetails()->delete();
            $promotion->delete();
            return $this->successResponse("Delete Promotion successfully", Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Promotion not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when show Promotion.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
