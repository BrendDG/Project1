<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class StorageController extends Controller
{
    /**
     * Serve files from storage/app/public
     */
    public function serve($path)
    {
        // Prevent directory traversal attacks
        $path = str_replace(['../', '..\\'], '', $path);

        // Get the full file path
        $filePath = storage_path('app/public/' . $path);

        // Debug: Check if file exists
        if (!file_exists($filePath)) {
            // Return detailed error for debugging
            return response()->json([
                'error' => 'File not found',
                'path' => $path,
                'full_path' => $filePath,
                'exists' => file_exists($filePath),
                'storage_path' => storage_path('app/public'),
            ], 404);
        }

        // Check if file is readable
        if (!is_readable($filePath)) {
            return response()->json([
                'error' => 'File is not readable',
                'path' => $path,
                'full_path' => $filePath,
                'permissions' => substr(sprintf('%o', fileperms($filePath)), -4),
            ], 403);
        }

        // Get mime type
        $mimeType = mime_content_type($filePath);

        // Return the file
        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }
}
