<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiFormRequest;

class CreateUserRequest extends ApiFormRequest
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
            'role_id'        => 'required|integer|min:0|max:1',
            'fullname'       => 'required|string|max:45',
            'avatar'         => 'image|mimes:png,jpg,jpeg',
            'birthday'       => 'date_format:"Y-m-d"',
            'address'        => 'string|max:255',
            'phone'          => 'regex:/^0[0-9]{9,10}$/',
            'gender'         => 'required|integer|min:0|max:1',
            'active'         => 'required|integer|min:0|max:1',
        ];
    }
}
