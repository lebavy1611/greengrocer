<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiFormRequest;

class CreatePromotionRequest extends ApiFormRequest
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
            'name'          => 'required|string|max:255',
            'image'         => 'image|mimes:jpeg,bmp,png',
            'start_date'    => 'required|date_format:"Y-m-d"',
            'end_date'      => 'required|date_format:"Y-m-d"|after:start_date',
        ];
    }
}
