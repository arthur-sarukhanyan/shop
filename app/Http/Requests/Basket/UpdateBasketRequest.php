<?php

namespace App\Http\Requests\Basket;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBasketRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'items.*.id' => 'required|numeric',
            'items.*.quantity' => 'required|numeric|min:1|max:99',
            'items.*.price' => 'required|numeric|min:0|max:99999',
        ];
    }
}
