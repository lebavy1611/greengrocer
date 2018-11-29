<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiFormRequest;

class UpdateUserRequest extends ApiFormRequest
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

            'password.required_with'        => "Yêu cầu bạn nhập lại password",
            'password.confirmed'            => "Password không khớp. Mời bạn nhập ",
            'password.string'               => "Password phải là chuỗi kí ",
            'password.min'                  => "Password ít 8 kí tự",

            'fullname.required'             => "Yêu cầu bạn nhập vào fullname",
            'fullname.string'               => "fullname phải là chuỗi kí ",
            'fullname.max'                  => "fullname không được quá 45 kí tự",

            'avatar.image'                  => "avatar phải là hình ảnh",
            'avatar.mimes'                  => "avatar phải đúng định dạng jpeg,bmp,png",

            'birthday.date_format'          => "Ngày sinh phải đúng định dạng y-m-d",

            'address.string'                =>  "Địa chỉ phải là chuỗi kí ",
            'address.max'                   => "Địa  không được quá 255 kí tự",


            'phone.regex'                   => "Số điện thoại phải đúng định  ",

            'gender.required'               => "Yêu cầu bạn nhập vào giới tính",
            'gender.integer'                => "Gender phải là số nguyên ",
            'gender.min'                    => "Gender  không được bé hơn 0",
            'gender.max'                    => "Gender  không được lớn hơn 1",

        ];

    }
}
