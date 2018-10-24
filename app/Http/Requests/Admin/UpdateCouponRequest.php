<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiFormRequest;
use App\Models\Coupon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route()->parameter('coupon');
        return [
            'code'          => 'required|string|unique:coupons,code,'.Coupon::find($id)->code.',code|max:255',
            'percents'      => 'required|integer|min:0|max:100',
            'start_date'    => 'required|date_format:"Y-m-d"',
            'end_date'      => 'required|date_format:"Y-m-d"|after:start_date',
            'times'         => 'required|integer|min:1|max:5',
        ];
    }
}
