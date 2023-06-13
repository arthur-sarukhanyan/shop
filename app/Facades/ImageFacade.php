<?php

namespace App\Facades;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Facade;

/**
 * @method static list(array $params)
 * @method static create(array $data): Model|Collection
 * @method static attachImage(int $itemId, string $itemType, UploadedFile $image)
 *
 * @see \App\Services\ImageService
 */
class ImageFacade extends Facade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor(): string
    {
        return 'ImageService';
    }
}
