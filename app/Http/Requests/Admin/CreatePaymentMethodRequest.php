<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreatePaymentMethodRequest extends ApiFormRequest
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
            'name'          => 'required|string|unique:payment_methods|max:255',
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
            'name.required'             => "Yêu cầu bạn nhập vào hình thức thanh toán",
            'name.string'               => "Hình thức thanh toán phải là chuỗi kí ",
            'name.max'                  => "Hình thức thanh toán không được quá 255 kí tự",
            'name.unique'               => "Hình thức thanh toán  không được trùng nhau",

        ];

    }
}
