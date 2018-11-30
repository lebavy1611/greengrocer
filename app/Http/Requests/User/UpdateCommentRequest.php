<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends ApiFormRequest
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
            'parent_id'         => 'required|integer',
            'content'           => 'required|string|max:255',
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

            'parent_id.required'             => "Vui lòng mời bạn nhập vào parent_id của commnent",
            'parent_id.integer'              => "Parent_id phải là số nguyên ",

            'content.required'             => "Vui lòng mời bạn nhập vào nội dung comment",
            'content.string'               => "Nội dung phải là chuỗi kí ",
            'content.max'                  => "Nội dung không được quá 255 kí tự",
        ];

    }
}
