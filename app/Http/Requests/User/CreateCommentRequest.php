<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateCommentRequest extends ApiFormRequest
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
            'product_id'        => 'required|integer|exists:products,id',
            'parent_id'         => 'required|integer|exists:comments',
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
            'product_id.required'             => "Vui lòng mời bạn nhập vào sản phâm",
            'product_id.integer'              => "Product_id phải là số nguyên ",
            'product_id.exists '              => "Product_id không tồn tại ",

            'parent_id.required'             => "Vui lòng mời bạn nhập vào parent_id của commnent",
            'parent_id.integer'              => "Parent_id phải là số nguyên ",
            'parent_id.exists '              => "Parent_id không tồn tại ",

            'content.required'             => "Vui lòng mời bạn nhập vào nội dung comment",
            'content.string'               => "Nội dung phải là chuỗi kí ",
            'content.max'                  => "Nội dung không được quá 255 kí tự",
        ];

    }
}
