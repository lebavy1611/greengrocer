<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Models\Coupon;
use Illuminate\Http\Response;

class CouponController extends ApiController
{
    public function checkCodeCoupon(Request $request)
    {
            $coupon = Coupon::where([
                ['code', $request->code],
                ['end_date', '>=', date("Y-m-d")],
                ['times', '>', 0]
            ])->first();
            if (!empty($coupon)) {
                return $this->successResponse($coupon, Response::HTTP_OK);
            } else {
                return $this->errorResponse('Mã giảm giá không tồn tại', Response::HTTP_NOT_FOUND);
            }
    }
}
