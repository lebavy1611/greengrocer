<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiFormRequest;
use App\Models\PaymentMethod;

class UpdatePaymentMethodRequest extends ApiFormRequest
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
        $id = $this->route()->parameter('payment');
        return [
            'name'          => 'required|string|unique:payment_methods,name,'.PaymentMethod::find($id)->name.',name|max:255',
        ];
    }
}
