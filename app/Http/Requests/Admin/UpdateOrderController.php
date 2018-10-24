<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderController extends ApiFormRequest
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
            'customer_id'          => 'required|integer|',
            'address'              => 'required|string|max:255',
            'delivery_time'        => 'required|date_format:"Y-m-d"',
            'note'                 => 'required|string|max:255',
            'processing_status'    => 'required|integer',
            'payment_status'       => 'required|integer',
            'payment_method_id'    => 'required|integer',
            'coupon_id'            => 'required|integer',
        ];
    }
}
