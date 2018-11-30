<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiFormRequest;

class UpdateManagerRequest extends ApiFormRequest
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
            'password'       => 'nullable|required_with:password_confirmation|string|confirmed|min:8',
            'fullname'       => 'required|string|max:45',
            'address'        => 'string|max:255',
            'phone'          => 'regex:/^0[0-9]{9,10}$/',
            'role'           => 'required'
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
            'password.required_with'        => "Vui lòng mời bạn nhập lại password",
            'password.confirmed'            => "Password không khớp. Mời bạn nhập ",
            'password.string'               => "Password phải là chuỗi kí ",
            'password.min'                  => "Password ít 8 kí tự",

            'fullname.required'             => "Vui lòng mời bạn nhập vào fullname",
            'fullname.string'               => "fullname phải là chuỗi kí ",
            'fullname.max'                  => "fullname không được quá 45 kí tự",

            'address.string'                =>  "Địa chỉ phải là chuỗi kí ",
            'address.max'                   => "Địa  không được quá 255 kí tự",


            'phone.regex'                   => "Số điện thoại phải đúng định  ",

            'role.required'                 => "Vui lòng mời bạn nhập chọn phân quyền",



        ];

    }
}
