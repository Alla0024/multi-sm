<?php

namespace App\Http\Controllers\Content;
use App\Http\Controllers\AppBaseController;


class ExampleController extends AppBaseController
{
    public function __construct()
    {
        $this->template = 'pages.example.item';
        parent::__construct();
    }
    public function index()
    {
        $vars['title'] = 'Приклади';
        return $this->renderOutput($vars);
    }
}
