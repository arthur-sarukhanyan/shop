<?php

namespace App\Http\Requests;

use App\Helpers\PaginationHelper;
use Illuminate\Foundation\Http\FormRequest;

class ListBaseRequest extends BaseRequest
{
    use PaginationHelper;

    protected function parsePagination(): void
    {
        if ($this->has('page')) {
            $page = $this->get('page');
            unset($this['page']);
            $this->merge(['pagination' => $this->createPaginationFromPage($page)]);
        }
    }

    protected function passedValidation(): void
    {
        $this->parsePagination();
    }
}
