<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\ListBaseRequest;

class ListProductRequest extends ListBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
