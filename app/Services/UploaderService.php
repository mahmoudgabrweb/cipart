<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Image;

class UploaderService
{
    public function uploadImage(UploadedFile $avatarFile, string $path, bool $applyCut = false, int $width = 200, int $height = 200): array
    {
        $avatarName = $this->generateRandomString() . "_" . time() . "." . $avatarFile->getClientOriginalExtension();

        try {
            $avatarImage = Image::make($avatarFile->getRealPath());

            if ($applyCut) {
                $avatarImage->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

            $avatarImage->stream();

            $isUploaded = Storage::put("$path/$avatarName", $avatarImage);

            return [$isUploaded, $path . "/" . $avatarName];
        } catch (\Exception $e) {
            return [false, ""];
        }
    }

    public function generateRandomString(int $n = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
}
