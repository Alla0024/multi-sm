<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Lang;
use Document;
use Event;

class AppBaseController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected array $vars = [];
    protected string $template = '';

    public function __construct()
    {
        $this->middleware('auth');

        $this->vars['word'] = Lang::get('common', []);
    }

    public function renderOutput($vars = []): Response
    {
        $this->vars['user'] = Auth::user();

        $this->loadLangByTemplate();

        return response()->view($this->template, array_merge($this->vars, $vars));
    }

    protected function loadLangByTemplate(): void
    {
        $defaultWord = Lang::has('default') ? Lang::get('default') : [];
        $parts = explode('.', $this->template);
        $langFile = $this->template ? $parts[2] : null;

        $this->vars['word'] += ($langFile && Lang::has($langFile))
            ? Lang::get($langFile)
            : $defaultWord;
    }
}
