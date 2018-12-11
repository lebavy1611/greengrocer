<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiFormRequest;

class CreatePromotionRequest extends ApiFormRequest
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
            'image'         => 'image|mimes:jpeg,bmp,png',
            'start_date'    => 'required|date_format:"Y-m-d"',
            'end_date'      => 'required|date_format:"Y-m-d"|after:start_date',
            'products'      => 'required',
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
            'name.required'             => "Vui lòng mời bạn nhập vào tên đợt khuyến mãi",
            'name.string'               => "Đợt khuyến mãi phải là chuỗi kí ",
            'name.max'                  => "Đợt khuyến  không được quá 255 kí tự",

            'image.image'               => "Image phải là hình ảnh",
            'image.mimes'               => "Image phải đúng định dạng jpeg,bmp,png",

            'start_date.required'       => "Vui lòng mời bạn nhập vào ngày bắt đầu khuyến mãi",
            'start_date.date_format'    => "Ngày bắt đầu khuyến mãi phải đúng định dạng y-m-d",

            'end_date.required'         => "Vui lòng mời bạn nhập vào ngày kết thúc khuyến mãi",
            'end_date.date_format'      => "Ngày kết thúc khuyến mãi phải đúng định dạng y-m-d",
            'end_date.after'            => "Ngày kết thúc khuyến mãi phải sau ngày bắt đầu khuyến mãi",
            'products.required'         => "Vui lòng mời bạn chọn sản phẩm",
        ];

    }
}
