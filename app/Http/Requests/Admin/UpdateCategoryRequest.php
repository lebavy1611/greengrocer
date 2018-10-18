<?php

namespace App\Http\Requests\Admin;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use  \App\Http\Requests\ApiFormRequest;

class UpdateCategoryRequest extends ApiFormRequest
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
        $id = $this->route()->parameter('category');
        return [
            'name'          => 'required|string|unique:categories,name,'.Category::find($id)->name.',name|max:255',
            'position'      => 'required|integer',
            'parent_id'     => 'required|integer',
            'image'         => 'nullable|image|mimes:jpeg,bmp,png',
        ];
    }
}
