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
}
