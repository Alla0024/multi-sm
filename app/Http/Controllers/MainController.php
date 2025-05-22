<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

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
        Document::pushStyle('css/input.min.css');
        Document::pushStyle('css/header.min.css');
        Document::pushScript(asset('js/app.min.js'), 0);
        Document::pushScript(asset('js/bootstrap.min.js'), 1);
        Document::pushScript(asset('js/events.min.js'), 2);
//        Document::pushScript(asset('js/home.min.js'), 2);
        $this->vars['styles'] = Document::getStyles();
        $this->vars['scripts'] = Document::getScripts();
        $this->vars['user'] = Auth::user();

        $vars['alpine'] = json_encode($this->vars + $vars);
        return response()->view($this->template, $this->vars + $vars);
    }
}
