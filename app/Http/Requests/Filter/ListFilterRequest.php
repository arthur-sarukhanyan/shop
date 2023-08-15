<?php

namespace App\Http\Requests\Filter;

use App\Http\Requests\ListBaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class ListFilterRequest extends ListBaseRequest
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
            //
        ];
    }
}
