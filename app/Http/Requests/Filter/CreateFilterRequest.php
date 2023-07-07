<?php

namespace App\Http\Requests\Filter;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateFilterRequest extends FormRequest
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
            'list.*.name' => 'required|string|max:100|min:1',
            'list.*.attr_1' => 'max:100',
            'list.*.attr_2' => 'max:100',
            'list.*.filter_group_id' => 'required|numeric',
        ];
    }
}
