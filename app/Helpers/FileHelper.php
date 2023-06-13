<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait FileHelper
{
    /**
     * @param UploadedFile $file
     * @param string $type
     * @return bool|string
     */
    public function storeFile(UploadedFile $file, string $type = 'file'): bool|string
    {
        $originalName = $file->getClientOriginalName();
        $name = time() . '-' . $type . '-' . $originalName;
        $path = $type . '/' . $name;
        $stored = Storage::disk('public')->put($path, File::get($file));

        if (!$stored) {
            return false;
        }

        return '/' . $path;
    }
}
