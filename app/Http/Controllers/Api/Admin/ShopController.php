<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\Shop;
use Illuminate\Http\Response;
use App\Http\Requests\Admin\CreateShopRequest;

class ShopController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops = Shop::orderBy('created_at', 'desc')->paginate(config('paginate.number_stores'));
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
            $newImage = '';
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $newImage = Carbon::now()->format('YmdHis_u') . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path(config('define.images_path_shops'));
                $image->move($destinationPath, $newImage);
            }
            $data = $request->only(['name', 'provider_id', 'address', 'phone', 'active']);
            $data['image'] = $newImage;
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
            return $this->successResponse($shop, Response::HTTP_OK);
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
    public function update(Request $request, $id)
    {
        try {
            $newImage = '';
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $newImage = Carbon::now()->format('YmdHis_u') . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path(config('define.images_path_shops'));
                $image->move($destinationPath, $newImage);
                $data['image'] = $newImage;
            }
            $data = $request->only(['name', 'provider_id', 'address', 'phone', 'active']);
            Shop::findOrFail($id)->update($data);
            return $this->successResponse(Shop::findOrFail($id), Response::HTTP_OK);
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
