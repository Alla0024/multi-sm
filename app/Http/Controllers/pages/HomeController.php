<?php

namespace App\Http\Controllers\Pages;
use Document;

use App\Http\Controllers\MainController;

class HomeController extends MainController
{
    public function __construct()
    {

        $this->template = 'pages.home';
        parent::__construct();
    }

    public function index()
    {


        return $this->renderOutput([]);
    }
}
