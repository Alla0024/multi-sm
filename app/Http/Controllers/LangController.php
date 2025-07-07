<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLangRequest;
use App\Http\Requests\UpdateLangRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Lang;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\AppBaseController;
use App\Repositories\LangRepository;
use Illuminate\Http\Request;
use Flash;

class LangController extends AppBaseController
{
    /** @var LangRepository $langRepository*/
    private $langRepository;

    public function __construct(LangRepository $langRepo)
    {
        parent::__construct();
        $this->langRepository = $langRepo;
    }

    /**
     * Display a listing of the Lang.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $table = (new \App\Models\Lang)->getTable();
        $schema = 'public';

        $fields = $this->getTableColumnsFromInformationSchema($table, $schema);

        $query = \App\Models\Lang::query();

        foreach ($fields as $field) {
            $name = $field['name'];
            if (!empty($field['searchable']) && $request->filled($name)) {
                $query->where($name, 'like', '%' . $request->input($name) . '%');
            }
        }

        $langs = $query->paginate($perPage);

        $vars['langs'] = $langs;
        $vars['fields'] = $fields;
        $this->template = 'pages.langs.index';
        return $this->renderOutput($vars);

    }

    private function getTableColumnsFromInformationSchema(string $table, string $schema): array
    {
        $columns = DB::select("
            SELECT
                column_name,
                data_type,
                character_maximum_length,
                is_nullable,
                column_default
            FROM information_schema.columns
            WHERE table_name = ? AND table_schema = ?
        ", [$table, $schema]);

        $fields = [];

        foreach ($columns as $column) {
            $name = $column->column_name;
            $type = $column->data_type;
            $length = $column->character_maximum_length;
            $nullable = $column->is_nullable === 'YES';
            $isPrimary = false;

            if ($column->column_default !== null && str_contains(strtolower($column->column_default), 'nextval')) {
                $isPrimary = true;
            }

            $rules = [];
            $rules[] = $nullable ? 'nullable' : 'required';

            if ($length && in_array($type, ['character varying', 'varchar', 'text'])) {
                $rules[] = 'max:' . $length;
            }

            $fields[] = [
                'name' => $name,
                'dbType' => $type,
                'htmlType' => $this->inferHtmlType($type),
                'validations' => implode('|', $rules),
                'searchable' => !str_ends_with($name, '_id') && !str_contains($name, 'password'),
                'fillable' => !$isPrimary,
                'primary' => $isPrimary,
                'inForm' => !$isPrimary,
                'inIndex' => true,
                'inView' => true,
            ];
        }

        return $fields;
    }

    private function inferHtmlType(string $dbType): string
    {
        return match ($dbType) {
            'character varying', 'varchar', 'text' => 'text',
            'integer', 'bigint', 'smallint' => 'number',
            'boolean' => 'checkbox',
            'date' => 'date',
            'timestamp without time zone', 'timestamp with time zone', 'timestamp' => 'datetime',
            default => 'text',
        };
    }
    /**
     * Show the form for creating a new Lang.
     */
    public function create()
    {

        $this->template = 'pages.langs.create';
        return $this->renderOutput();
    }

    /**
     * Store a newly created Lang in storage.
     */
    public function store(CreateLangRequest $request)
    {
        $input = $request->all();

        $lang = $this->langRepository->create($input);

        Flash::success('Lang saved successfully.');

        return redirect(route('langs.index'));
    }

    /**
     * Display the specified Lang.
     */
    public function show($id)
    {
        $lang = $this->langRepository->find($id);

        if (empty($lang)) {
            Flash::error('Lang not found');

            return redirect(route('langs.index'));
        }

        $vars['lang'] = $lang;
        $this->template = 'pages.langs.show';
        return $this->renderOutput($vars);
    }

    /**
     * Show the form for editing the specified Lang.
     */
    public function edit($id)
    {
        $lang = $this->langRepository->find($id);

        if (empty($lang)) {
            Flash::error('Lang not found');

            return redirect(route('langs.index'));
        }

        $vars['lang'] = $lang;
        $this->template = 'pages.langs.edit';
        return $this->renderOutput($vars);
    }

    /**
     * Update the specified Lang in storage.
     */
    public function update($id, UpdateLangRequest $request)
    {
        $lang = $this->langRepository->find($id);

        if (empty($lang)) {
            Flash::error('Lang not found');

            return redirect(route('langs.index'));
        }

        $lang = $this->langRepository->update($request->all(), $id);

        Flash::success('Lang updated successfully.');

        return redirect(route('langs.index'));
    }

    /**
     * Remove the specified Lang from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $lang = $this->langRepository->find($id);

        if (empty($lang)) {
            Flash::error('Lang not found');

            return redirect(route('langs.index'));
        }

        $this->langRepository->delete($id);

        Flash::success('Lang deleted successfully.');

        return redirect(route('langs.index'));
    }
}
