<?php

namespace App\Http\Controllers\pages;
use Document;

use App\Http\Controllers\MainController;

class ManufacturerController extends MainController
{
    public function __construct()
    {

        $this->template = 'pages.manufacturers.list';
        parent::__construct();
    }

    public function index()
    {
        $vars['title'] = 'Виробники';
        return $this->renderOutput($vars);
    }
    public function edit()
    {
        $vars['title'] = 'Редагування';
        $this->template = 'pages.manufacturers.item';
        return $this->renderOutput($vars);
    }
}
