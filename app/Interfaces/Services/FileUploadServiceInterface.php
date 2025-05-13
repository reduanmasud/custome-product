<?php

namespace App\Interfaces\Services;

use Illuminate\Http\UploadedFile;

interface FileUploadServiceInterface
{
    /**
     * Upload a file to the specified directory
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string|null $filename
     * @return string The file path
     */
    public function upload(UploadedFile $file, string $directory, ?string $filename = null): string;

    /**
     * Upload a base64 encoded file
     *
     * @param string $base64String
     * @param string $directory
     * @param string $extension
     * @return string The file path
     */
    public function uploadBase64(string $base64String, string $directory, string $extension = 'jpg'): string;

    /**
     * Delete a file
     *
     * @param string $path
     * @return bool
     */
    public function delete(string $path): bool;
}
