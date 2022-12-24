<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = $this->route('category', 0);

        return [
            'name' => 'required|string|max:255',
            'slug' => "nullable|string|unique:categories,slug,$id",
            'parent_id' => 'nullable|int|exists:categories,id',
            'image' => [
                'nullable',
                'image',
                'max:200',
                //'dimensions:min_width=300,min_height=300,max_width=800,max_height=300',
                Rule::dimensions()->minWidth(300)->minHeight(300)->maxWidth(1400)->maxHeight(1400),
            ]
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute is required!!',
            'slug.required' => 'You must eneter a URL slug!',
        ];
    }
}
