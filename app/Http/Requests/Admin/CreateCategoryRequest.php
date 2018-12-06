<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiFormRequest;

class CreateCategoryRequest extends ApiFormRequest
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
            'name'          => 'required|string|unique:categories|max:255',
            'position'      => 'integer',
            'parent_id'     => 'required|integer',
            'image'         => 'required|image|mimes:jpeg,bmp,png',
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
            'name.required'             => "Vui lòng mời bạn nhập vào tên danh mục sản phẩm",
            'name.string'               => "Tên danh mục sản phẩm phải là chuỗi kí ",
            'name.max'                  => "Tên danh mục sản phẩm không được quá 255 kí tự",
            'name.unique'               => "Tên danh mục sản phẩm đã tồn tại.",

            'position.integer'          => "Vị trí danh mục sản phẩm phải là số nguyên",

            'parent_id.required'        => "Parent danh mục sản phẩm không được trống ",
            'parent_id.integer'         => "Parent danh mục sản phẩm  phải là số nguyên",

            'image.image'               => "Image phải là hình ảnh",
            'image.mimes'               => "Image phải đúng định dạng jpeg,bmp,png",
            'image.required'             => "Vui lòng mời bạn chọn ảnh",
        ];

    }
}
