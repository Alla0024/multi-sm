<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLangRequest;
use App\Http\Requests\UpdateLangRequest;
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

        $columns = Schema::getColumnListing((new Lang)->getTable());

        $query = Lang::query();

        foreach ($columns as $field) {
            if ($request->filled($field)) {
                $query->where($field, 'like', '%' . $request->input($field) . '%');
            }
        }

        $langs = $query->paginate($perPage);

        // Pass columns to the view
        $vars['langs'] = $langs;
        $vars['fields'] = $columns;
        $this->template = 'pages.aikqweu.langs.index';
        return $this->renderOutput($vars);
    }

    /**
     * Show the form for creating a new Lang.
     */
    public function create()
    {
        return view('pages.aikqweu.langs.create');
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

        return view('pages.aikqweu.langs.show')->with('lang', $lang);
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

        return view('pages.aikqweu.langs.edit')->with('lang', $lang);
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
