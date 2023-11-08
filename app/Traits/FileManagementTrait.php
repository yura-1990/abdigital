<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait FileManagementTrait
{
    public function uploadFile(UploadedFile $file, string $folder): string
    {
        return Storage::disk('public')->put($folder, $file);
    }

    public function deleteFile($file): bool
    {
        if ($file){
            return Storage::disk('public')->delete($file);
        }

        return false;
    }
}
