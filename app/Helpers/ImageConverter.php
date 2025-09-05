<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageConverter
{
    public static function convert($filepath, $extension = 'jpg'): string
    {
        $filename = pathinfo($filepath, PATHINFO_FILENAME);
        $dirname = pathinfo($filepath, PATHINFO_DIRNAME);

        $new_filepath = $dirname . '/' . $filename . '.' . $extension;

        $manager = new ImageManager(new Driver());
        $image = $manager->read($filepath);
        switch ($extension) {
            case 'jpg':
                $image->toJpeg(90)->save($new_filepath);
                break;
            case 'webp':
                $image->toWebp(90)->save($new_filepath);
                break;
            default:
                break;
        }

        return 'success';
    }


    public static function convertFolder(string $relativeFolder): void
    {
        $baseStoragePath = storage_path('app/public/' . trim($relativeFolder, '/'));

        if (!is_dir($baseStoragePath)) return;

        $files = File::allFiles($baseStoragePath);

        $width = config('settings.images.category.width');
        $height = config('settings.images.category.height');

        $product_width = config('settings.images.product.width');
        $product_height = config('settings.images.product.height');

        foreach ($files as $file) {
            if ($file->getExtension() !== 'jpg') continue;

            $sourcePath = self::normalizePath($file->getRealPath());
            $storageBase = self::normalizePath(storage_path('app/public/images/'));
            $relativePath = str_replace($storageBase, '', $sourcePath);

            $targetDir = dirname(public_path('images/' . $relativePath));
            $targetFileBase = $targetDir . '/' . pathinfo($relativePath, PATHINFO_FILENAME);
            $targetJpgPath = $targetFileBase . '.jpg';

            if (!File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0777, true, true);
            }

            if (!File::exists($targetJpgPath)) {
                File::copy($sourcePath, $targetJpgPath);
            }

            self::convert($targetJpgPath, 'webp');

            $relativePublicPath = 'storage/images/' . $relativePath;

            PictureHelper::rewrite($relativePublicPath, $width, $height, false);
            PictureHelper::rewrite($relativePublicPath, $product_width, $product_height, false);
        }
    }


    protected static function getResizedFileName(string $relativePath, int $width, int $height, string $ext): string
    {
        $info = pathinfo($relativePath);
        return $info['dirname'] . '/' . $info['filename'] . "-{$width}x{$height}." . $ext;
    }

    protected static function normalizePath(string $path): string
    {
        return str_replace('\\', '/', $path);
    }
}
