<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ListBaseRequest;

class ListUserRequest extends ListBaseRequest
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
