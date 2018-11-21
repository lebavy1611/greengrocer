<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiFormRequest;

class UpdateProductRequest extends ApiFormRequest
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
            'shop_id'       => 'required|integer',
            'category_id'   => 'required|integer',
            'describe'      => 'string|max:255',
            'price'         => 'required|integer',
            'origin'        => 'required|string|max:255',
            'quantity'      => 'required|integer',
//            'imported_date' => 'required|date_format:"Y-m-d"',
//            'expired_date'  => 'required|date_format:"Y-m-d"|after:imported_date',
            'active'        => 'integer|min:0|max:1',
        ];
    }
}