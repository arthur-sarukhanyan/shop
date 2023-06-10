<?php

namespace App\Repositories;

use App\Models\Image;
use App\Repositories\Interfaces\ImageInterface;
class ImageRepository extends ModelRepository implements ImageInterface
{
    public function __construct()
    {
        parent::__construct(Image::class);
    }
}
