<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiFormRequest;

class CreateRatingRequest extends ApiFormRequest
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
            'product_id'        => 'required|integer',
            'stars'             => 'required|integer|min:1|max:5',
            'content'           => 'required|string|max:255',
        ];
    }
}
