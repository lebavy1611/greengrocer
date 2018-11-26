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
}
