<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\ListBaseRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class ListProductRequest extends ListBaseRequest
{
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
