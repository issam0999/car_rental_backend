<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class FileHelper
{
    public static function saveBase64Image($base64Image, $directory)
    {
        // Decode the base64 image
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));

        // Generate a unique filename
        $fileName = uniqid().'.png'; // assuming PNG, adjust as needed

        // Define the full path
        $filePath = $directory.'/'.$fileName;

        // Store the image in the specified directory
        Storage::disk('public')->put($filePath, $imageData);

        return $filePath; // return the relative path
    }

    public static function deleteImage($imagePath)
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }

    // Files
    public static function storeFile($documentable_type, $file)
    {
        $folder = strtolower(class_basename($documentable_type));
        $centerId = Common::centerId();
        // Store file
        $path = $file->store("documents/{$centerId}/{$folder}", 'public');

        return $path;
    }

    public static function deleteFile($path)
    {
        if ($path && Storage::exists($path)) {
            Storage::delete($path);
        }
    }

    public static function getImageUrl($path)
    {
        // return asset('storage/'.$filePath);
        $url = Storage::disk('public')->url($path);

        return $url;

    }
}
