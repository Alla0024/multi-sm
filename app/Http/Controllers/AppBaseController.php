<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Lang;
use Document;
use Event;

class AppBaseController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
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
