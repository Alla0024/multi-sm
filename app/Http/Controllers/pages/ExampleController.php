<?php

namespace App\Http\Controllers\pages;
use Document;

use App\Http\Controllers\MainController;

class ExampleController extends MainController
{
    public function __construct()
    {
        $this->template = 'pages.example.list';
        parent::__construct();
    }
    public function index()
    {
        $vars['title'] = 'Приклади';
        return $this->renderOutput($vars);
    }
    public function edit()
    {
        $vars['title'] = 'Редагування';
        $this->template = 'pages.example.item';
        return $this->renderOutput($vars);
    }
}
