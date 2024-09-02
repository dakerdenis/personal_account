<?php

namespace App\Repository\Eloquent;

use App\Models\Media;
use App\Repository\FileRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class FileRepository extends BaseRepository implements FileRepositoryInterface
{
    private array $extensions = ['image/png' => 'png', 'image/jpeg' => 'jpg', 'image/jpg' => 'jpg'];

    public function __construct(Media $model)
    {
        parent::__construct($model, false);
    }

    public function format(mixed $image, array $dimensions, string $path, string $disk = 'public', $returnFullPath = false): array
    {
        $preview = Image::make($image);
        $extension = $this->extensions[$preview->mime];
        $filename = Str::random(16) . time();
        Storage::disk($disk)->put($path . '/' . $filename . ".$extension", $preview->encode($extension));
        Storage::disk($disk)->put($path . '/' . $filename . '.webp', $preview->encode('webp', 60));
        foreach ($dimensions as $dimension) {
            $preview = Image::make($image);
            $width = $dimension[1] ?? null;
            $height = $dimension[2] ?? null;
            switch ($dimension[0]) {
                case 'original':
                    Storage::disk($disk)->put($path . '/' . $filename . "_{$width}x" . ($height ?? 'auto') . ".$extension", $preview->encode($extension));
                    Storage::disk($disk)->put($path . '/' . $filename . "_{$width}x" . ($height ?? 'auto') . '.webp', $preview->encode('webp', 60));
                    break;
                case 'fit':
                    Storage::disk($disk)->put($path . '/' . $filename . "_{$width}x" . ($height ?? 'auto') . ".$extension", $preview->fit($width, $height)->encode($extension));
                    Storage::disk($disk)->put($path . '/' . $filename . "_{$width}x" . ($height ?? 'auto') . '.webp', $preview->fit($width, $height)->encode('webp', 60));
                    break;
                case 'resize':
                    Storage::disk($disk)->put($path . '/' . $filename . "_{$width}x" . ($height ?? 'auto') . ".$extension", $preview->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode($extension));
                    Storage::disk($disk)->put($path . '/' . $filename . "_{$width}x" . ($height ?? 'auto') . '.webp', $preview->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode('webp', 60));
                    break;
                case 'resizeBack':
                    Storage::disk($disk)->put($path . '/' . $filename . "_{$height}x" . ($width ?? 'auto') . ".$extension", $preview->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode($extension));
                    Storage::disk($disk)->put($path . '/' . $filename . "_{$height}x" . ($width ?? 'auto') . '.webp', $preview->resize($width, $height, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->encode('webp', 60));
                    break;
                case 'resize_and_height_crop':
                    Storage::disk($disk)->put($path . '/' . $filename . "_{$width}x" . ($height ?? 'auto') . ".$extension", $preview->resize($width, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->crop($width, $height)->encode($extension));
                    Storage::disk($disk)->put($path . '/' . $filename . "_{$width}x" . ($height ?? 'auto') . '.webp', $preview->resize($width, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->crop($width, $height)->encode('webp', 60));
                    break;
                case 'resize_and_width_crop':
                    Storage::disk($disk)->put($path . '/' . $filename . "_{$width}x" . ($height ?? 'auto') . ".$extension", $preview->resize(null, $height, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->crop($width, $height)->encode($extension));
                    Storage::disk($disk)->put($path . '/' . $filename . "_{$width}x" . ($height ?? 'auto') . '.webp', $preview->resize(null, $height, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->crop($width, $height)->encode('webp', 60));
                    break;
            }
        }

        return [$filename, $extension];
    }

    public function convertToWebp(mixed $image): \Intervention\Image\Image
    {
        $preview = Image::make($image);
        return $preview->encode('jpg', 80);
    }

    public function update(int $id, array $data): bool
    {
        return $this->find($id)->update($data);
    }

}
