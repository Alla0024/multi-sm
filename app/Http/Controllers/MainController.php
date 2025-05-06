<?php

namespace App\Http\Controllers;

use Document;
class MainController extends Controller
{
    protected $template;
    protected $vars = [];

    public function __construct()
    {

    }

    public function renderOutput($vars)
    {
        Document::pushStyle('css/app.min.css');
        Document::pushStyle('css/header.min.css');
        Document::pushScript('js/home.min.js');
        $this->vars['styles'] = Document::getStyles();
        $this->vars['scripts'] = Document::getScripts();
        $this->vars['data'] = ['name' => 'Dima'];

        return response()->view($this->template, $this->vars + $vars);
    }
}
