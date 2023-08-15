<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    /**
     * @param Request $request
     * @param JsonResponse $response
     * @return void
     */
    public function withResponse(Request $request, JsonResponse $response): void
    {
        if (isset($this['code'])) {
            $response->setStatusCode($this['code']);
        } else {
            $response->setStatusCode(400);
        }
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => $this['message'],
        ];
    }
}
