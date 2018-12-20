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

    protected $account;

    /**
     * CategoryController constructor..
     *
     * @param UploadImageService   $uploadImageService   UploadImageService
     */
    public function __construct(UploadImageService $uploadImageService)
    {
        $this->uploadImageService = $uploadImageService;
        $this->account = auth('api')->user();
    }
 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops = Shop::with('provider')->orderBy('created_at', 'desc')->get();
        if ($shops->count()) {
            if ($this->account->can('view', $shops->first())) {
                return $this->showAll($shops, Response::HTTP_OK);
            } else {
                return $this->errorResponse(config('define.no_authorization'), Response::HTTP_UNAUTHORIZED);
            }
        } else {
            return $this->showAll($shops, Response::HTTP_OK);
        }
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
            $data = $request->only(['name', 'manager_id', 'address', 'phone', 'active']);
            if (accountLogin()->role == Manager::ROLE_PROVIDER) {
                $data['manager_id'] = accountLogin()->id;
                if ($this->account->can('create', Shop::class)) {
                    $data = $request->only(['name', 'provider_id', 'address', 'phone', 'active']);
                    if (accountLogin()->role == Manager::ROLE_PROVIDER) {
                        $data['provider_id'] = accountLogin()->id;
                    }
                    $data['image'] = $this->uploadImageService->fileUpload($request, 'shops', 'image');
                    $shop = Shop::create($data);    
                    return $this->successResponse($shop->load('provider'), Response::HTTP_OK);
                } else {
                    return $this->errorResponse(config('define.no_authorization'), Response::HTTP_UNAUTHORIZED);
                }
            }
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
    public function show(Shop $shop)
    {
        try {
            if ($this->account->can('view', $shop)) {
                return $this->successResponse($shop->load('provider'), Response::HTTP_OK);
            } else {
                return $this->errorResponse(config('define.no_authorization'), Response::HTTP_UNAUTHORIZED);
            }
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
    public function update(CreateShopRequest $request, Shop $shop)
    {
        try {
            if ($this->account->can('update', $shop)) {
                if ($request->hasFile('image')) {
                    $data['image'] = $this->uploadImageService->fileUpload($request, 'shops', 'image');
                }
                $data = $request->only(['name', 'provider_id', 'address', 'phone', 'active']);
                if (accountLogin()->role == Manager::ROLE_PROVIDER) {
                    $data['provider_id'] = accountLogin()->id;
                }
                $shop->update($data);
                return $this->successResponse(Shop::with('provider')->findOrFail($id), Response::HTTP_OK);
            } else {
                return $this->errorResponse(config('define.no_authorization'), Response::HTTP_UNAUTHORIZED);
            }
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
    public function destroy(Shop $shop)
    {
        try {
            if ($this->account->can('delete', $shop)) {
                $shop->products()->delete();
                $shop->delete();
                return $this->successResponse("Delete shop successfully.", Response::HTTP_OK);
            } else {
                return $this->errorResponse(config('define.no_authorization'), Response::HTTP_UNAUTHORIZED);
            }
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("shop not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when delete shop.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
