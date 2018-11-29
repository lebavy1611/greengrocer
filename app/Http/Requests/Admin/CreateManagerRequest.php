<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiFormRequest;

class CreateManagerRequest extends ApiFormRequest
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
            'username'       => 'required|string|max:32|unique:managers',
            'email'          => 'required|string|email|max:25|unique:managers',
            'password'       => 'required|string|min:8',
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
            'username.required'             => "Yêu cầu bạn nhập vào username",
            'username.string'               => "Username phải là chuỗi kí ",
            'username.max'                  => "Username không được quá 255 kí tự",
            'username.unique'               => "Username không được trùng nhau",

            'email.required'                => "Email không được trống",
            'email.string'                  => "Email phải là chuỗi kí ",
            'email.email'                   => "Email phải đúng định dạng",
            'email.max'                     => "Email không được quá 25 kí tự",
            'email.unique'                  => "Email không được trùng nhau",

            'password.required'             => "Yêu cầu bạn nhập vào password",
            'password.string'               => "Password phải là chuỗi kí ",
            'password.min'                  => "Password ít 8 kí tự",

            'fullname.required'             => "Yêu cầu bạn nhập vào fullname",
            'fullname.string'               => "fullname phải là chuỗi kí ",
            'fullname.max'                  => "fullname không được quá 45 kí tự",

            'address.string'                =>  "Địa chỉ phải là chuỗi kí ",
            'address.max'                   => "Địa  không được quá 255 kí tự",


            'phone.regex'                   => "Số điện thoại phải đúng định  ",

            'role.required'               => "Yêu cầu bạn nhập chọn phân quyền",



        ];

    }
}
