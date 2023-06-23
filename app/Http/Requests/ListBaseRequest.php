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

        $data = $this->all();
        $filters = [];

        foreach ($data as $key => $value) {
            if (str_contains($key, 'filters-')) {
                $field = str_replace('filters-', '', $key);
                $type = '=';

                if (str_contains($value, '|')) {
                    $parts = explode('|', $value);
                    $value = $parts[0];
                    $type = $parts[1];
                }

                $filter = ['field' => $field, 'value' => $value, 'type' => $type];
                $filters[] = $filter;
                unset($this->$key);
            }
        }

        if (count($filters)) {
            $this->merge(['filters' => $filters]);
        }
    }

    protected function passedValidation(): void
    {
        $this->parsePagination();
    }
}
