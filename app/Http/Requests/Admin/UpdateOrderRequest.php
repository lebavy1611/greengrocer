<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends ApiFormRequest
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
            'processing_status'    => 'required|integer|exists:process_statuses,id',
            'payment_status'       => 'required|integer|in:1,2',
            'delivery_time'        => 'required|date_format:"Y-m-d"',
        ];
    }

    /**
     * Custom message error for rules
     *
     * @return void
     */

    public function messages()
    {

        return [
            'processing_status.required'             => "Vui lòng mời bạn chọn để huỷ đơn hàng",
            'processing_status.integer'               => "Trạng thái huỷ đơn hàng phải là số nguyên",
            'processing_status.exists'            => "Vui lòng chọn trạng thái xử lý hợp lệ",

            'payment_status.required'             => "Vui lòng mời bạn nhập vào trạng thái thanh toán",
            'payment_status.integer'              => "id trạng thái thanh toán phải là số nguyên ",
            'payment_status.in'                    => "Trạng thái thanh toán không hợp lệ (1,2)",

            'delivery_time.required'       => "Vui lòng mời bạn nhập vào ngày bắt đầu giao hàng",
            'delivery_time.date_format'    => "Ngày bắt đầu khuyến mãi phải đúng định dạng y-m-d",

        ];

    }
}
