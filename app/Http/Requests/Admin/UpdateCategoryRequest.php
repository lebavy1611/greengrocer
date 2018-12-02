<?php

namespace App\Http\Requests\Admin;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use  \App\Http\Requests\ApiFormRequest;

class UpdateCategoryRequest extends ApiFormRequest
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
        $id = $this->route()->parameter('category');
        return [
            'name'          => 'required|string|unique:categories,name,'.Category::find($id)->name.',name|max:255',
            'position'      => 'required|integer',
            'parent_id'     => 'required|integer',
            'image'         => 'nullable|image|mimes:jpeg,bmp,png',
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
            'name.unique'               => "Tên danh mục sản phẩm không được trùng nhau",

            'position.required'         => "Vị trí danh mục sản phẩm không được trống ",
            'position.integer'          => "Vị trí danh mục sản phẩm phải là số nguyên",

            'parent_id.required'        => "Parent danh mục sản phẩm không được trống ",
            'parent_id.integer'         => "Parent danh mục sản phẩm  phải là số nguyên",

            'image.image'               => "Image phải là hình ảnh",
            'image.mimes'               => "Image phải đúng định dạng jpeg,bmp,png",
        ];

    }
}
