<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasImagePost
{

    public function updateImagePost(UploadedFile $photo)
    {
        tap($this->image_url, function ($previous) use ($photo) {
            $this->forceFill([
                'image_url' => $photo->storePublicly(
                    'public/image-post',
                    ['disk' => $this->ImageDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->ImageDisk())->delete($previous);
            }
        });
    }

    public function deleteImagePost()
    {
        Storage::disk($this->ImageDisk())->delete($this->image_url);

        $this->forceFill([
            'image_url' => null,
        ])->save();
    }

    public function getImagesUrlAttribute()
    {
        return $this->image_url
            ? Storage::disk($this->ImageDisk())->url($this->image_url)
            : $this->defaultImageUrl();
    }


    protected function defaultImageUrl()
    {
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->title) . '&color=D8FFF5&background=1E2139';
    }

    protected function ImageDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : env('FILESYSTEM_DRIVER', 'public');
    }
}
