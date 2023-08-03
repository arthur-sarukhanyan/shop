<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'company_name' => 'min:3|max:100',
            'email' => 'required|email',
            'first_name' => 'required|min:3|max:100',
            'last_name' => 'required|min:3|max:100',
            'address_1' => 'required|min:3|max:100',
            'address_2' => 'min:3|max:100',
            'zip' => 'required|min:3|max:12',
            'country_id' => 'required|numeric',
            'city' => 'required|min:3|max:100',
            'phone' => 'required|min:8|max:19',
            'notes' => 'min:3|max:999',
        ];
    }
}
