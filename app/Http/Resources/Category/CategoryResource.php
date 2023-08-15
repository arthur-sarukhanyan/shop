<?php

namespace App\Http\Resources\Category;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $name
 * @property int $parent_id
 * @property string $path
 * @property Model|null $parent
 */
class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'parent_id' => $this->parent_id,
            'path' => $this->path,
        ];

        if ($this->parent) {
            $data['parent'] = new CategoryResource($this->whenLoaded('parent'));
        }

        return $data;
    }
}
