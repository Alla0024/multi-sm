<?php

namespace App\Http\Controllers\FileManager;

class DemoController extends LfmController
{
    public function index()
    {
        return view('laravel-filemanager::demo');
    }
}
