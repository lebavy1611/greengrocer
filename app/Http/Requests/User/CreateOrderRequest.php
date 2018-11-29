<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends ApiFormRequest
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
        return [
            'products'             => 'required',
            'full_name'            => 'required|string|max:255',
            'phone'                => 'required|regex:/^0[0-9]{9,10}$/',
            'address'              => 'required|string|max:255',
            'delivery_time'        => 'required|date_format:"Y-m-d"',
            'note'                 => 'string|max:255',
            'payment_method_id'    => 'required|integer',
            'coupon_id'            => 'integer',
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
            'products.required'             => "Yêu cầu bạn nhập vào sản phẩm",

            'full_name.required'             => "Yêu cầu bạn nhập vào fullname",
            'full_name.string'               => "fullname phải là chuỗi kí ",
            'full_name.max'                  => "fullname không được quá 45 kí tự",

            'address.required'              => "Yêu cầu bạn nhập vào địa chỉ",
            'address.string'                =>  "Địa chỉ phải là chuỗi kí ",
            'address.max'                   => "Địa  không được quá 255 kí tự",

            'phone.required'                => "Yêu cầu bạn nhập vào số điện thoại",
            'phone.regex'                   => "Số điện thoại phải đúng định  ",

            'delivery_time.required'       => "Yêu cầu bạn nhập vào ngày bắt đầu giao hàng",
            'delivery_time.date_format'    => "Ngày bắt đầu khuyến mãi phải đúng định dạng y-m-d",

            'note.string'                   => "Note phải là chuỗi kí ",
            'note.max'                      => "Note không được quá 255 kí tự",

            'payment_method_id.required'    => "Yêu cầu bạn nhập vào hình thức thanh toán",
            'payment_method_id.integer'     => "Id hình thức thanh toán phải là số nguyên ",

            'coupon_id.integer'             => "Id hình thức khuyến mãi phải là số nguyên ",

        ];

    }
}
