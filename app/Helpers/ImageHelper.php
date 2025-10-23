<?php

if (!function_exists('image_path')) {
    function image_path($path = '', $width = null, $height = null)
    {
        $filename = pathinfo($path, PATHINFO_FILENAME);
        $dirname = pathinfo($path, PATHINFO_DIRNAME);
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $available_extensions = ['jpg', 'png'];

        if ($width && $height && in_array($extension, $available_extensions)) {
            return 'https://i.svit-matrasiv.com.ua/images/' . $dirname . '/' . $filename . '-' . $width . 'x' . $height . '.' . $extension;
        }

        return 'https://i.svit-matrasiv.com.ua/images/' . $dirname . '/' . $filename . '.' . $extension;
    }
}
