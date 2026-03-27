<?php

namespace App\Services;

use App\Enum\MediaType;
use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class MediaService
{

    public static function getTypeFrom(string $clientMimeType): ?string
    {
        return match ($clientMimeType) {
            'application/pdf' => MediaType::PDF->value,
            'image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/svg', 'image/gif' => MediaType::IMAGE->value,
            default => null,
        };
    }

    public static function upload(UploadedFile $file, string $path, ?string $name = null, ?int $documentTypeId = null, ?Model $fileable = null): Media|Model
    {
        $mediaType = self::getTypeFrom(clientMimeType: $file->getClientMimeType());
        $filePath = $file->store($path);

        return Media::query()->create([
            'src' => $filePath,
            'type' => $mediaType,
            'extension' => $file->getClientOriginalExtension(),
            'name' => $name,
            'fileable_id' => $fileable?->id,
            'fileable_type' => $fileable ? get_class($fileable) : null,
        ]);
    }


 
}
