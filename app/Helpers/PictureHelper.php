<?php

namespace App\Helpers;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PictureHelper
{

    public static function rewrite($filepath, $width = null, $height = null, $checkExists = true)
    {
        $filepath = trim($filepath, '/');
        if (str_contains($filepath, 'storage/images')) {
            $filepath = substr($filepath, 15);
        }

        if ($filepath == '' || !file_exists(app()->publicPath() . '/storage/images/' . $filepath)) {
            $filename = 'no_images';
            $dirname = 'common';
            $extension = 'png';
            $resource_filepath = app()->resourcePath() . '/assets/images/common/no_images.png';
        } else {
            $filename = pathinfo($filepath, PATHINFO_FILENAME);
            $dirname = pathinfo($filepath, PATHINFO_DIRNAME);
            $extension = pathinfo($filepath, PATHINFO_EXTENSION);
            $resource_filepath = app()->publicPath() . '/storage/images/' . $filepath;
        }

        $new_filepath = '/images/' . $dirname . '/' . $filename;
        if ($width && $height) {
            $new_filepath .= '-' . $width . 'x' . $height;
        }
        $new_filepath .= '.' . $extension;

        $public_filepath = app()->publicPath() . $new_filepath;

        if ($checkExists) {
            if (file_exists($public_filepath)) {
                return asset($new_filepath);
            }
        }
        $manager = new ImageManager(new Driver());

        $img = $manager->read($resource_filepath);
        if ($width && $height) {
            $img->resize($width, $height);
        }

        $path = '';

        $directories = explode('/', $dirname);
        $default_path = app()->publicPath() . '/images/';
        foreach ($directories as $directory) {
            $path = $path . '/' . $directory;
            if (!is_dir($default_path . $path)) {
                if (!mkdir($concurrentDirectory = $default_path . $path, 0777) && !is_dir($concurrentDirectory)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
                }
            }
        }

        $img->save($public_filepath);

        $webp_filepath = $default_path . $dirname . '/' . $filename . '-' . $width . 'x' . $height . '.webp';

        if ($extension === 'jpg' && (!$checkExists || !file_exists($webp_filepath))) {
            ImageConverter::convert($public_filepath, 'webp');
        }

        return asset($new_filepath);
    }

    public static function noRewrite($filepath)
    {
        $filepath = trim($filepath, '/');
        if (str_contains($filepath, 'storage/images')) {
            $filepath = substr($filepath, 15);
        }

        if ($filepath == '' || !file_exists(app()->publicPath() . '/storage/images/' . $filepath)) {
            $filename = 'no_images';
            $dirname = 'common';
            $extension = 'png';
            $new_filepath = '/images/' . $dirname . '/' . $filename . '.' . $extension;
            $resource_filepath = app()->resourcePath() . '/assets/images/common/no_images.png';
        } else {
            $filename = pathinfo($filepath, PATHINFO_FILENAME);
            $dirname = pathinfo($filepath, PATHINFO_DIRNAME);
            $extension = pathinfo($filepath, PATHINFO_EXTENSION);
            $new_filepath = '/images/' . $dirname . '/' . $filename . '.' . $extension;
            $resource_filepath = app()->publicPath() . '/storage/images/' . $filepath;
        }

        $public_filepath = app()->publicPath() . $new_filepath;

        if (file_exists($public_filepath)) {
            return asset($new_filepath);
        }

        $path = '';

        $directories = explode('/', $dirname);
        $default_path = app()->publicPath() . '/images/';
        foreach ($directories as $directory) {
            $path = $path . '/' . $directory;
            if (!is_dir($default_path . $path)) {
                mkdir($default_path . $path, 0777);
            }
        }

        if ($extension == 'svg' || $extension == 'gif') {
            copy($resource_filepath, $public_filepath);
        } else {
            $manager = new ImageManager(new Driver());
            $img = $manager->read($resource_filepath);
            $img->save($public_filepath);
        }

        return asset($new_filepath);
    }

}
