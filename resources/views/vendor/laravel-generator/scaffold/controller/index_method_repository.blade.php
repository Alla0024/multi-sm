    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        ${{ $config->modelNames->camelPlural }} = $this->{{ $config->modelNames->camel }}Repository->paginate($perPage);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            {{ $config->modelNames->name }}::class
        ]);

        $this->template = 'pages.{{ $config->modelNames->snakePlural }}.index';

        return $this->renderOutput([
            '{{ $config->modelNames->camelPlural }}' => ${{ $config->modelNames->camelPlural }},
            'fields' => $fields,
        ]);
    }
