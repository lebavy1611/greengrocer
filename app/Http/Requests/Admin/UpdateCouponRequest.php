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
            'percents'      => 'required|integer|min:0|max:100',
            'start_date'    => 'required|date_format:"Y-m-d"',
            'end_date'      => 'required|date_format:"Y-m-d"|after:start_date',
            'times'         => 'required|integer|min:1',
        ];
    }

    /**
     * Custom message error for rules
     *
     * @return void
     */

    public function messages()
    {

        return [
            'percents.required'         => "Vui lòng mời bạn nhập vào phần trăm khuyến mã",
            'percents.integer'          => "Phần trăm phải là số nguyên ",
            'percents.min'              => "Phần trăm khuyến mãi không được bé hơn 0",
            'percents.max'              => "Phần trăm khuyến mãi không được lớn hơn 100",

            'start_date.required'       => "Vui lòng mời bạn nhập vào ngày bắt đầu khuyến mãi",
            'start_date.date_format'    => "Ngày bắt đầu khuyến mãi phải đúng định dạng y-m-d",

            'end_date.required'         => "Vui lòng mời bạn nhập vào ngày kết thúc khuyến mãi",
            'end_date.date_format'      => "Ngày kết thúc khuyến mãi phải đúng định dạng y-m-d",
            'end_date.after'            => "Ngày kết thúc khuyến mãi phải sau ngày bắt đầu khuyến mãi",

            'times.required'            => "Vui lòng mời bạn nhập vào số lần khuyến mãi",
            'times.integer'             => "Số lần khuyến mãi phải là số nguyên ",
            'times.min'                 => "Số lần khuyến mãi không được bé hơn 1",
        ];

    }
}
