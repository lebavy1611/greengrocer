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
}
