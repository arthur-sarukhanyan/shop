<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Repositories\Interfaces\ImageInterface as RepositoryInterface;
use App\Services\Interfaces\ImageInterface as ServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class ImageService extends BaseService implements ServiceInterface
{
    use FileHelper;

    /**
     * @param RepositoryInterface $modelRepository
     */
    public function __construct(RepositoryInterface $modelRepository)
    {
        parent::__construct($modelRepository);
    }

    /**
     * @param int $itemId
     * @param string $itemType
     * @param UploadedFile $image
     * @return Model
     */
    public function attachImage(int $itemId, string $itemType, UploadedFile $image): Model
    {
        $path = $this->storeFile($image, 'images');

        $data = [
            'type' => $itemType,
            'item_id' => $itemId,
            'path' => $path
        ];

        $created = parent::create($data);
        return $created;
    }

}
