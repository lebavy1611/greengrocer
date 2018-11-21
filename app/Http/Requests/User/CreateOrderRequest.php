<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends ApiFormRequest
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
            'products'             => 'required',
            'full_name'             => 'required|string|max:255',
            'phone'                => 'regex:/^0[0-9]{9,10}$/',
            'address'              => 'required|string|max:255',
            'delivery_time'        => 'required|date_format:"Y-m-d"',
            'note'                 => 'string|max:255',
            'payment_method_id'    => 'required|integer',
            'coupon_id'            => 'integer',
        ];
    }
}
