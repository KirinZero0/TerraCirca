<?php

namespace App\Models\Traits;

use App\Jobs\DeleteImageProcess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;

trait HandleUpload
{
    public static function bootHandleUpload(): void
    {
        static::saving(function (Model $model) {
            if ($model->isDirty($model->imageAttribute())) {
                if (blank($model->{$model->imageAttribute()})) {
                    $model->deleteLatestImage();
                }

                if (($model->{$model->imageAttribute()} instanceof UploadedFile)) {
                    $model->deleteLatestImage();
                    $model->saveImage();
                }
            }
        });

        static::deleting(function (Model $model) {
            $model->deleteLatestImage();
            $model->{$model->imageAttribute()} = null;
            $model->saveOrFail();
        });
    }

    public function imageAttribute(): string
    {
        return 'photo';
    }

    public function deleteLatestImage(): void
    {
        if (blank($this->getOriginalImage())) return;

        $path = $this->getFullImagePath();

        if (Storage::disk($this->getImageDisk())->exists($path)) {
            DeleteImageProcess::dispatch($path, $this->getImageDisk())->afterCommit();
        }
    }

    public function getOriginalImage()
    {
        return $this->getRawOriginal($this->imageAttribute());
    }

    public function getFullImagePath(): string
    {
        $fileName = $this->getOriginalImage();

        return $this->getImagePath() . '/' . $fileName;
    }

    public function hasImage(): bool
    {
        return !blank($this->{$this->imageAttribute()});
    }

    public function saveImage(): void
    {
        /** @var \Illuminate\Http\UploadedFile $image */
        $image = $this->{$this->imageAttribute()};
        $image->store($this->getImagePath(), $this->getImageDisk());
        $this->setAttribute($this->imageAttribute(), $image->hashName());
    }

    public function getImageDisk(): string
    {
        return 'public';
    }

    public function getImageUrl(): string
    {
        if(! $this->hasImage()) {
            return 'https://www.pngitem.com/pimgs/m/22-223968_default-profile-picture-circle-hd-png-download.png';
        }

        return Storage::disk($this->getImageDisk())->url($this->getFullImagePath());
    }

    public function getImagePath(): string
    {
        return 'images';
    }

    public function saveBase64($image): void
    {
        $imageInfo = explode(";base64,", $image);
        $imgExt = str_replace('data:image/', '', $imageInfo[0]);
        $image = str_replace(' ', '+', $imageInfo[1]);
        $imageName = rand().".".$imgExt;

        if(! in_array($imgExt, ['png', 'jpg', 'jpeg'])) {
            abort(403);
        }

        Storage::disk('public')->put($this->getImagePath() . '/' . $imageName, base64_decode($image));
    }

    public function convertToFile($base64File): UploadedFile
    {
        $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64File));

        $tmpFilePath = sys_get_temp_dir() . '/' . Str::uuid()->toString();
        file_put_contents($tmpFilePath, $fileData);

        $tmpFile = new File($tmpFilePath);

        return new UploadedFile(
            $tmpFile->getPathname(),
            $tmpFile->getFilename(),
            $tmpFile->getMimeType(),
            0,
            false
        );
    }
}
