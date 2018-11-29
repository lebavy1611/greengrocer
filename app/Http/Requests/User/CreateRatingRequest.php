<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiFormRequest;

class CreateRatingRequest extends ApiFormRequest
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
            'product_id'        => 'required|integer',
            'stars'             => 'required|integer|min:1|max:5',
            'content'           => 'required|string|max:255',
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
            'product_id.required'             => "Yêu cầu bạn nhập vào sản phâm",
            'product_id.integer'              => "Product_id phải là số nguyên ",

            'stars.required'             => "Yêu cầu bạn nhập vào parent_id của commnent",
            'stars.integer'              => "Parent_id phải là số nguyên ",
            'stars.min'                 => "stars không được bé hơn 1",
            'stars.max'                 => "stars không được hơn hơn 5",

            'content.required'             => "Yêu cầu bạn nhập vào nội dung comment",
            'content.string'               => "Nội dung phải là chuỗi kí ",
            'content.max'                  => "Nội dung không được quá 255 kí tự",
        ];

    }
}
