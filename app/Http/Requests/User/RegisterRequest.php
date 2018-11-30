<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiFormRequest;

class RegisterRequest extends ApiFormRequest
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
            'username'       => 'required|string|max:32|unique:users',
            'email'          => 'required|string|email|max:25|unique:users',
            'password'       => 'required|string|min:8',
            'fullname'       => 'required|string|max:45',
            'avatar'         => 'image|mimes:png,jpg,jpeg',
            'birthday'       => 'date_format:"Y-m-d"',
            'address'        => 'string|max:255',
            'phone'          => 'regex:/^0[0-9]{9,10}$/',
            'gender'         => 'required|integer|min:0|max:1',
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
            'username.required'             => "Vui lòng mời bạn nhập vào username",
            'username.string'               => "Username phải là chuỗi kí ",
            'username.max'                  => "Username không được quá 32 kí tự",
            'username.unique'               => "Username không được trùng nhau",

            'email.required'                => "Email không được trống",
            'email.string'                  => "Email phải là chuỗi kí ",
            'email.email'                   => "Email phải đúng định dạng",
            'email.max'                     => "Email không được quá 25 kí tự",
            'email.unique'                  => "Email không được trùng nhau",

            'password.required'             => "Vui lòng mời bạn nhập vào password",
            'password.string'               => "Password phải là chuỗi kí ",
            'password.min'                  => "Password ít 8 kí tự",

            'fullname.required'             => "Vui lòng mời bạn nhập vào fullname",
            'fullname.string'               => "fullname phải là chuỗi kí ",
            'fullname.max'                  => "fullname không được quá 45 kí tự",

            'avatar.image'                  => "avatar phải là hình ảnh",
            'avatar.mimes'                  => "avatar phải đúng định dạng jpeg,bmp,png",

            'birthday.date_format'          => "Ngày sinh phải đúng định dạng y-m-d",

            'address.string'                =>  "Địa chỉ phải là chuỗi kí ",
            'address.max'                   => "Địa  không được quá 255 kí tự",


            'phone.regex'                   => "Số điện thoại phải đúng định  ",

            'gender.required'               => "Vui lòng mời bạn nhập vào giới tính ",
            'gender.integer'                => "Gender phải là số nguyên ",
            'gender.min'                    => "Gender  không được bé hơn 0",
            'gender.max'                    => "Gender  không được lớn hơn 1",

        ];

    }
}
