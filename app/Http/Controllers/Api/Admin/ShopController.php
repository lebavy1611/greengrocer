<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\Shop;
use Illuminate\Http\Response;
use App\Http\Requests\Admin\CreateShopRequest;
use App\Services\UploadImageService;
use App\Models\Manager;

class ShopController extends ApiController
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
        $shops = Shop::with('provider')->orderBy('created_at', 'desc')->paginate(config('paginate.number_stores'));
        $shops = $this->formatPaginate($shops);
        return $this->showAll($shops, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateShopRequest $request)
    {
        try {
            $data = $request->only(['name', 'provider_id', 'address', 'phone', 'active']);
            if (accountLogin()->role == Manager::ROLE_PROVIDER) {
                $data['provider_id'] = accountLogin()->id;
            }
            $data['image'] = $this->uploadImageService->fileUpload($request, 'shops', 'image');
            $shop = Shop::create($data);    
            return $this->successResponse($shop, Response::HTTP_OK);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when insert category.", Response::HTTP_INTERNAL_SERVER_ERROR);
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
            $shop = Shop::findOrFail($id);
            return $this->successResponse($shop->load('provider'), Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Shop not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when show shop.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateShopRequest $request, $id)
    {
        try {
            if ($request->hasFile('image')) {
                $data['image'] = $this->uploadImageService->fileUpload($request, 'shops', 'image');
            }
            $data = $request->only(['name', 'provider_id', 'address', 'phone', 'active']);
            if (accountLogin()->role == Manager::ROLE_PROVIDER) {
                $data['provider_id'] = accountLogin()->id;
            }
            Shop::findOrFail($id)->update($data);
            return $this->successResponse(Shop::with('provider')->findOrFail($id), Response::HTTP_OK);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when insert shop.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $shop = Shop::findOrfail($id)->delete();
            return $this->successResponse("Delete shop successfully.", Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("shop not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when delete shop.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
