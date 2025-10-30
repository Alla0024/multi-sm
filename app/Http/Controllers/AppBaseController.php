<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Store;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Document;
use Event;

class AppBaseController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected array $vars = [];
    protected string $template = '';
    protected array $defaultSortFields = [
        'default',
        'name_asc',
        'name_desc',
        'created_at_asc',
        'created_at_desc',
    ];

    public function __construct()
    {
        $this->middleware('auth');

        $this->vars['word'] = Lang::get('common', []);
        $this->vars['languages'] = Language::getLanguages();
        $this->vars['stores'] = Store::getStores();
        $this->vars['sortFields'] = $this->defaultSortFields;
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

        if ($this->template && Str::startsWith($this->template, 'pages.')) {
            $withoutPrefix = Str::after($this->template, 'pages.');
            $langFile = Str::beforeLast($withoutPrefix, '.');

            if (Lang::has($langFile)) {
                $this->vars['word'] += Lang::get($langFile);
                return;
            }
        }

        $this->vars['word'] += $defaultWord;
    }

}

