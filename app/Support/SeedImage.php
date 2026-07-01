<?php

namespace App\Support;

use Illuminate\Support\Facades\File;

class SeedImage
{
    public static function storeOptimized(string $source, string $destination, int $quality = 82, int $maxSize = 1200): ?string
    {
        if (! File::exists($source)) {
            return null;
        }

        File::ensureDirectoryExists(dirname($destination));

        $webpDestination = preg_replace('/\.[^.]+$/', '.webp', $destination);
        $extension = strtolower(pathinfo($source, PATHINFO_EXTENSION) ?: 'jpg');
        $tempSource = sys_get_temp_dir() . '/' . uniqid('seed_img_', true) . '.' . $extension;

        File::copy($source, $tempSource);

        $resize = proc_open(
            ['sips', '-Z', (string) $maxSize, $tempSource, '--out', $tempSource],
            [['pipe', 'r'], ['pipe', 'w'], ['pipe', 'w']],
            $pipes
        );

        if (is_resource($resize)) {
            fclose($pipes[0]);
            stream_get_contents($pipes[1]);
            stream_get_contents($pipes[2]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($resize);
        }

        $convert = proc_open(
            ['cwebp', '-q', (string) $quality, '-m', '6', $tempSource, '-o', $webpDestination],
            [['pipe', 'r'], ['pipe', 'w'], ['pipe', 'w']],
            $pipes
        );

        $success = false;

        if (is_resource($convert)) {
            fclose($pipes[0]);
            $stderr = stream_get_contents($pipes[2]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            $success = proc_close($convert) === 0 && File::exists($webpDestination);
        }

        @unlink($tempSource);

        if (! $success) {
            File::copy($source, $destination);

            return str_replace(storage_path('app/public') . DIRECTORY_SEPARATOR, '', $destination);
        }

        return str_replace(storage_path('app/public') . DIRECTORY_SEPARATOR, '', $webpDestination);
    }
}
