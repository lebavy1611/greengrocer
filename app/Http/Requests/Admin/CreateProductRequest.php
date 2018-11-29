<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends ApiFormRequest
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
            'name'          => 'required|string|max:255',
            'shop_id'       => 'required|integer',
            'category_id'   => 'required|integer',
            'describe'      => 'string|max:255',
            'price'         => 'required|integer',
            'origin'        => 'required|string|max:255',
            'quantity'      => 'required|integer',
//            'imported_date' => 'required|date_format:"Y-m-d"',
//            'expired_date'  => 'required|date_format:"Y-m-d"|after:imported_date',
//            'active'         => 'required|integer|min:0|max:1',
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
            'name.required'             => "Yêu cầu bạn nhập vào tên sản phẩm",
            'name.string'               => "Tên sản phẩm phải là chuỗi kí ",
            'name.max'                  => "Tên sản phẩm không được quá 255 kí tự",

            'shop_id.required'          => "Cửa hàng không được trống",
            'shop_id.integer'           => "Id của hàng phải là số nguyên",

            'category_id.required'      => "Danh mục sản phẩm không được trống",
            'category_id.integer'       => "Id danh phải là số nguyên",

            'describe.string'           => "Mô tả sản phẩm phải là chuỗi kí ",
            'describe.max'              => "Mô tả sản phẩm không được quá 255 kí tự",

            'price.required'            => "Giá không được trống",
            'price.integer'             => "Gía bán phải là số nguyên",

            'origin.required'           => "Yêu cầu bạn nhập vào nguồn gốc sản phẩm",
            'origin.string'             => "Nguồn gốc sản phẩm phải là chuỗi kí ",
            'origin.max'                => "Nguồn gốc sản phẩm không được quá 255 kí tự",

            'quantity.required'         => "Số lượng không được trống",
            'quantity.integer'          => "Số lượng phải là số nguyên",

        ];

    }

}
