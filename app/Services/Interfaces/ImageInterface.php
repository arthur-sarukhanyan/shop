<?php

namespace App\Services\Interfaces;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

/**
 * @see \App\Services\ImageService
 */
interface ImageInterface extends ServiceInterface
{
    /**
     * @param int $itemId
     * @param string $itemType
     * @param UploadedFile $image
     * @return Model
     */
    public function attachImage(int $itemId, string $itemType, UploadedFile $image): Model;
}
