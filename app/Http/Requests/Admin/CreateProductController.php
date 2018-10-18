<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductController extends ApiFormRequest
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
            'describe'      => 'required|string|max:255',
            'price'         => 'required|integer',
            'origin'        => 'required|string|max:255',
            'quantity'      => 'required|integer',
            'imported_date' => 'required|date_format:"Y-m-d"',
            'expired_date'  => 'required|date_format:"Y-m-d"',
            'active'         => 'required|integer|min:0|max:1',
        ];
    }
}
