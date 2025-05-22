<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Lang;
use Document;
use Event;

class MainController extends Controller
{
    protected $template;
    protected $vars = [];
    protected $time;

    public function __construct()
    {
        $this->middleware('auth');

        $this->vars = [];

        $this->vars['word'] = Lang::get('dashboard');
    }

    public function renderOutput($vars = [])
    {
        Document::pushStyle('css/app.min.css');
        Document::pushStyle('css/header.min.css');
        Document::pushScript(asset('js/app.min.js'), 0);
        Document::pushScript(asset('js/bootstrap.min.js'), 1);
        Document::pushScript(asset('js/home.min.js'), 2);

        $this->vars['user'] = Auth::user();
        $this->vars['styles'] = Document::getStyles();
        $this->vars['scripts'] = Document::getScripts();

        $vars['alpine'] = json_encode($this->vars + $vars);

        return response()->view($this->template, $this->vars + $vars);
    }

    private function header()
    {
        $data['user_info'] = Auth::getUser();
        $data['word'] = $this->vars['word'];

        return $data;
    }

    private function leftSidebar()
    {
        $data['user_info'] = Auth::getUser()->toArray();
        $data['word'] = $this->vars['word'];

        return $data;
    }

    private function rightSidebar()
    {

    }

    private function footer()
    {
        $data['user_info'] = Auth::getUser()->toArray();

        return $data;
    }

}
