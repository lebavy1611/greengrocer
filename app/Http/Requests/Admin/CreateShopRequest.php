<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiFormRequest;

class CreateShopRequest extends ApiFormRequest
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
            'name'        => 'required|string|max:255',
            'provider_id' => 'required|integer|exists:users,id',
            'address'     => 'required',
            'phone'       => 'required|regex:/^0[0-9]{9,10}$/',
            'image'       => 'image|mimes:png,jpg,jpeg',
            'active'      => 'integer|min:0|max:1'
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
            'name.required'             => "Yêu cầu bạn nhập vào tên của hàng",
            'name.string'               => "Tên của hàng phải là chuỗi kí ",
            'name.max'                  => "Tên của hàng không được quá 255 kí tự",

            'provider_id.required'      => "Yêu cầu bạn nhập vào tên chủ cửa hàng",
            'provider_id.integer'       => "Id_provider của hàng phải là số nguyên",

            'address.required'          => "Địa chỉ cửa hàng không được trống",

            'phone.required'            => "Yêu cầu bạn nhập vào số điện thoại của hàng",
            'phone.regex'               => "Số điện thoại của hàng phải đúng định  ",

            'image.image'               => "Image phải là hình ảnh",
            'image.mimes'               => "Image phải đúng định dạng jpeg,bmp,png",

            'active.integer'             => "Active phải là số nguyên ",
            'active.min'                 => "Active không được bé hơn 0",
            'active.max'                 => "Active không được hơn hơn 1",

        ];

    }
}
