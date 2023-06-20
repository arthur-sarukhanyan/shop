<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100|min:1',
            'description' => 'required|string|max:200|min:1',
            'price' => 'required|numeric|max:999999|min:0',
            'image' => 'file|mimes:jpeg,png,jpg,gif,webp',
            'category_id' => 'required',
            'category_id.*' => 'required|numeric',
        ];
    }
}
