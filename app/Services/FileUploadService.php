<?php

namespace App\Services;

use App\Interfaces\Services\FileUploadServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService implements FileUploadServiceInterface
{
    /**
     * Upload a file to the specified directory
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string|null $filename
     * @return string The file path
     */
    public function upload(UploadedFile $file, string $directory, ?string $filename = null): string
    {
        if (!$filename) {
            $filename = time() . rand(1, 1000) . '.' . $file->getClientOriginalExtension();
        }

        $file->move(public_path($directory), $filename);

        return $filename;
    }

    /**
     * Upload a base64 encoded file
     *
     * @param string $base64String
     * @param string $directory
     * @param string $extension
     * @return string The file path
     */
    public function uploadBase64(string $base64String, string $directory, string $extension = 'jpg'): string
    {
        // Extract the base64 content
        $data = explode(',', $base64String);
        $base64Data = isset($data[1]) ? $data[1] : $base64String;
        
        // Decode the base64 data
        $decodedData = base64_decode($base64Data);
        
        // Generate a unique filename
        $filename = time() . rand(1, 1000) . '.' . $extension;
        
        // Store the file
        Storage::disk('public')->put($filename, $decodedData);
        
        return $filename;
    }

    /**
     * Delete a file
     *
     * @param string $path
     * @return bool
     */
    public function delete(string $path): bool
    {
        if (file_exists(public_path($path))) {
            return unlink(public_path($path));
        }
        
        return Storage::disk('public')->delete($path);
    }
}
