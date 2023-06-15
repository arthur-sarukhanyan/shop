<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'list.*.name' => 'required|string|max:100|min:1',
            'list.*.description' => 'required|string|max:200|min:1',
            'list.*.price' => 'required|numeric|max:999999|min:0',
            'list.*.image' => 'file|mimes:jpeg,png,jpg,gif,webp',
            'list.*.category_id' => 'required',
            'list.*.category_id.*' => 'required|numeric',
        ];
    }
}
