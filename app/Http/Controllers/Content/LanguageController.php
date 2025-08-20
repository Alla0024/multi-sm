<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use App\Repositories\LanguageRepository;
use Flash;
use Illuminate\Http\Request;

class LanguageController extends AppBaseController
{
    /** @var LanguageRepository $languageRepository*/
    private $languageRepository;

    public function __construct(LanguageRepository $languageRepo)
    {
        $this->languageRepository = $languageRepo;
        parent::__construct();
    }

    /**
     * Display a listing of the Language.
     */
    public function index(Request $request)
    {
        $languages = $this->languageRepository->paginate(10);
        $vars['languages'] = $languages;
        $this->template = 'pages.languages.index';
        return $this->renderOutput($vars);
    }

    /**
     * Show the form for creating a new Language.
     */
    public function create()
    {
        return view('pages.languages.create');
    }

    /**
     * Store a newly created Language in storage.
     */
    public function store(CreateLanguageRequest $request)
    {
        $input = $request->all();

        $language = $this->languageRepository->create($input);

        Flash::success('Language saved successfully.');

        return redirect(route('pages.languages.index'));
    }

    /**
     * Display the specified Language.
     */
    public function show($id)
    {
        $language = $this->languageRepository->find($id);

        if (empty($language)) {
             Flash::error(__('common.flash_not_found'));

            return redirect(route('pages.languages.index'));
        }

        return view('pages.languages.show')->with('language', $language);
    }

    /**
     * Show the form for editing the specified Language.
     */
    public function edit($id)
    {
        $language = $this->languageRepository->find($id);

        if (empty($language)) {
             Flash::error(__('common.flash_not_found'));

            return redirect(route('pages.languages.index'));
        }

        return view('pages.languages.edit')->with('language', $language);
    }

    /**
     * Update the specified Language in storage.
     */
    public function update($id, UpdateLanguageRequest $request)
    {
        $language = $this->languageRepository->find($id);

        if (empty($language)) {
             Flash::error(__('common.flash_not_found'));

            return redirect(route('pages.languages.index'));
        }

        $language = $this->languageRepository->update($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        return redirect(route('pages.languages.index'));
    }

    /**
     * Remove the specified Language from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $language = $this->languageRepository->find($id);

        if (empty($language)) {
             Flash::error(__('common.flash_not_found'));

            return redirect(route('pages.languages.index'));
        }

        $this->languageRepository->delete($id);

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('pages.languages.index'));
    }
}
