<?php

namespace App\Models;

use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producer extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function ImageProducer(UploadedFile $photo)
    {
        tap($this->image, function ($previous) use ($photo) {
            $this->forceFill([
                'image' => $photo->storePublicly(
                    'public/image-producer',
                    ['disk' => $this->ImageDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->ImageDisk())->delete($previous);
            }
        });
    }

    public function deleteImage()
    {
        Storage::disk($this->ImageDisk())->delete($this->image);

        $this->forceFill([
            'image' => null,
        ])->save();
    }

    protected function ImageDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : env('FILESYSTEM_DRIVER', 'public');
    }
}
