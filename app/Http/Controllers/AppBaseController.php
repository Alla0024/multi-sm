<?php

namespace App\Http\Controllers;

use App\Helpers\ModelSchemaHelper;
use App\Models\ArticleAuthor;
use App\Models\Information;
use App\Models\InformationDescription;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsCategoryDescription;
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

        if ($this->template && Str::startsWith($this->template, 'pages.')) {
            $withoutPrefix = Str::after($this->template, 'pages.');
            $langFile = Str::beforeLast($withoutPrefix, '.');

            if (Lang::has($langFile)) {
                $this->vars['word'] += Lang::get($langFile);
                return;
            } else {
                $this->generateLangFileFromFields($langFile);

                if (Lang::has($langFile)) {
                    $this->vars['word'] += Lang::get($langFile);
                    return;
                }
            }
        }

        $this->vars['word'] += $defaultWord;
    }
    protected function generateLangFileFromFields(string $filename): void
    {

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            ArticleAuthor::class,
        ]);

        $lang = [
            ucfirst(substr($filename, 0, -1)) => $filename,
        ];

        foreach ($fields as $name => $config) {
            $lang["title_$name"] = "title_$name";
            $lang["search_$name"] = "search_$name";
        }

        $lang['tab_main'] = 'tab_main';
        $lang['tab_sort'] = 'tab_sort';

        $content = "<?php\n\nreturn [\n";
        foreach ($lang as $key => $value) {
            $content .= "    '$key' => '$value',\n";
        }
        $content .= "];\n";

        $path = resource_path("lang\uk\\".$filename.".php");

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        file_put_contents($path, $content);
    }

}
