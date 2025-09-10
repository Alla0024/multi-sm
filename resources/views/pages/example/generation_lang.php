<?php
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
        CategoryDescription::class,
        Category::class,
    ]);

    $lang = [
        ucfirst(substr($filename, 0, -1)) => $filename,
        'error_news_not_found' => 'Статтю не знайдено',
        'success_news_deleted' => 'Видалено успішно',
        'success_news_saved' => 'Збережено успішно',
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

    $path = resource_path("lang/uk/".$filename.".php");

    if (!file_exists(dirname($path))) {
        mkdir(dirname($path), 0755, true);
    }

    file_put_contents($path, $content);
}
