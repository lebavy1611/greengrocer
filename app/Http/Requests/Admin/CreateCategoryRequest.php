<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiFormRequest;

class CreateCategoryRequest extends ApiFormRequest
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
            'name'          => 'required|string|unique:categories|max:255',
            'position'      => 'required|integer',
            'parent_id'     => 'required|integer',
            'image'         => 'image|mimes:jpeg,bmp,png',
        ];
    }
}
