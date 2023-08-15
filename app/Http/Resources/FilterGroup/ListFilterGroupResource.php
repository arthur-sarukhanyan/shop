<?php

namespace App\Http\Resources\FilterGroup;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ListFilterGroupResource extends ResourceCollection
{
    public $collects = FilterGroupResource::class;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
