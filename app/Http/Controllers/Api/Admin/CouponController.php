<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\CreateCouponRequest;
use App\Http\Requests\Admin\UpdateCouponRequest;
use App\Models\Coupon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Category;

class CouponController extends ApiController
{
    protected $account;

    /**
     * CategoryController constructor..
     *
     * @param UploadImageService   $uploadImageService   UploadImageService
     */
    public function __construct()
    {
        $this->account = auth('api')->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $coupons = Coupon::orderBy('created_at', 'desc')->get();
            if ($coupons->count()) {
                if ($this->account->can('view', $coupons->first())) {
                    return $this->successResponse($coupons, Response::HTTP_OK);
                } else {
                    return $this->errorResponse(config('define.no_authorization'), Response::HTTP_UNAUTHORIZED);
                }
            } else{
                return $this->successResponse($coupons, Response::HTTP_OK);
            }
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return $this->errorResponse("Coupons can not be show.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCouponRequest $request)
    {
        try {
            if ($this->account->can('create', Category::class)) {
                $data = $request->only([
                    'percents', 'start_date','end_date', 'times',
                ]);
                $data['code'] = getCodeCoupon(8);
                $coupon = Coupon::create($data);
                return $this->successResponse($coupon, Response::HTTP_OK);
            } else {
                return $this->errorResponse(config('define.no_authorization'), Response::HTTP_UNAUTHORIZED);
            }
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when insert coupon.", Response::HTTP_INTERNAL_SERVER_ERROR);
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
            $coupon = Coupon::findOrFail($id);
            if ($this->account->can('view', $coupon)) {
                return $this->successResponse($coupon, Response::HTTP_OK);
            } else {
                return $this->errorResponse(config('define.no_authorization'), Response::HTTP_UNAUTHORIZED);
            }
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Coupon not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when show Coupon.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCouponRequest $request, $id)
    {
        try {
            $coupon = Coupon::findOrFail($id);
            if ($this->account->can('update', $coupon)) {
                $data = $request->only([
                    'code', 'percents', 'start_date','end_date', 'times',
                ]);
                $coupon->update($data);
                return $this->successResponse($coupon, Response::HTTP_OK);
            } else {
                return $this->errorResponse(config('define.no_authorization'), Response::HTTP_UNAUTHORIZED);
            }
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Coupon not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when show Coupon.", Response::HTTP_INTERNAL_SERVER_ERROR);
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
            $coupon = Coupon::findOrFail($id);
            if ($this->account->can('delete', $coupon)) {
                $coupon->delete();
                return $this->successResponse("Delete coupon successfully", Response::HTTP_OK);
            } else {
                return $this->errorResponse(config('define.no_authorization'), Response::HTTP_UNAUTHORIZED);
            }
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Coupon not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when show Coupon.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
