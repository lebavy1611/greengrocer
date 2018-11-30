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
        $provider = 'provider'; 
        return [
            'name'        => 'required|string|max:255',
            'provider_id' => 'required|integer|exists:managers,id,role,' .$provider,
            'address'     => 'required',
            'phone'       => 'required|regex:/^0[0-9]{9,10}$/',
            'image'       => 'image|mimes:png,jpg,jpeg',
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
            'name.required'             => "Vui lòng mời bạn nhập vào tên của hàng",
            'name.string'               => "Tên của hàng phải là chuỗi kí ",
            'name.max'                  => "Tên của hàng không được quá 255 kí tự",

            'provider_id.required'      => "Vui lòng mời bạn nhập vào tên chủ cửa hàng",
            'provider_id.integer'       => "Id_provider của cửa hàng phải là số nguyên",
            'provider_id.exists'        => "Id_provider của cửa hàng phải tồn tại và phải là provider",

            'address.required'          => "Địa chỉ cửa hàng không được trống",

            'phone.required'            => "Vui lòng mời bạn nhập vào số điện thoại của hàng",
            'phone.regex'               => "Số điện thoại của hàng phải đúng định  ",

            'image.image'               => "Image phải là hình ảnh",
            'image.mimes'               => "Image phải đúng định dạng jpeg,bmp,png"
        ];

    }
}
