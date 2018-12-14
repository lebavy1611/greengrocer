<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiFormRequest;

class UpdateProductRequest extends ApiFormRequest
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
            'shop_id'       => 'required|integer|exists:shops,id',
            'category_id'   => 'required|integer|exists:categories,id',
            'describe'      => 'string|max:255',
            'price'         => 'required|integer',
            'origin'        => 'required|string|max:255',
            'quantity'      => 'required|integer',
            'active'        => 'integer|min:0|max:1',
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
            'name.required'             => "Vui lòng mời bạn nhập vào tên sản phẩm",
            'name.string'               => "Tên sản phẩm phải là chuỗi kí ",
            'name.max'                  => "Tên sản phẩm không được quá 255 kí tự",

            'shop_id.required'          => "Cửa hàng không được trống ",
            'shop_id.integer'           => "Id của hàng phải là số nguyên",
            'shop_id.exists'            => "Id của hàng không tồn tại",

            'category_id.required'      => "Danh mục sản phẩm không được trống",
            'category_id.integer'       => "Id danh phải là số nguyên",
            'category_id.exists'       => "Id danh mục sản phẩm không tồn tại",

            'describe.string'           => "Mô tả sản phẩm phải là chuỗi kí ",
            'describe.max'              => "Mô tả sản phẩm không được quá 255 kí tự",

            'price.required'            => "Giá không được trống",
            'price.integer'             => "Gía bán phải là số nguyên",

            'origin.required'           => "Vui lòng mời bạn nhập vào nguồn gốc sản phẩm",
            'origin.string'             => "Nguồn gốc sản phẩm phải là chuỗi kí ",
            'origin.max'                => "Nguồn gốc sản phẩm không được quá 255 kí tự",

            'quantity.required'         => "Số l không được trống",
            'quantity.integer'          => "Số lượng phải là số nguyên",

            'active.integer'            => "Trạng thái hoạt động phải là số nguyên",
            'active.max'                => "Trạng thái hoạt động không được lớn hơn 1",
            'active.min'                => "Trạng thái hoạt động không được bé hơn 0",
        ];

    }
}
