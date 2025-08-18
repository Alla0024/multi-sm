<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateOptionValueRequest;
use App\Http\Requests\UpdateOptionValueRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\OptionValueDescription;
use App\Repositories\LanguageRepository;
use App\Repositories\OptionValueRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\OptionValue;
use Flash;

class OptionValueController extends AppBaseController
{
    /**
     * @var OptionValueRepository $optionValueRepository
     * @var LanguageRepository $languageRepository
     */
    private OptionValueRepository $optionValueRepository;
    private LanguageRepository $languageRepository;
    private int $defaultLanguageId;

    public function __construct(OptionValueRepository $optionValueRepo, LanguageRepository $languageRepo)
    {
        parent::__construct();

        $this->optionValueRepository = $optionValueRepo;
        $this->languageRepository = $languageRepo;
        $this->defaultLanguageId = config('settings.locale.default_language_id');
    }

    /**
     * Display a listing of the OptionValue.
     */
    public function index(Request $request, $id = null)
    {
        $perPage = $request->input('perPage', 10);

        $optionValues = $this->optionValueRepository->filterIndexPage($perPage, request()->all(), $this->defaultLanguageId, $id);

        $breadcrumbs = $this->optionValueRepository->getBreadCrumbsRecursive($id, $this->defaultLanguageId);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            OptionValue::class
        ], [
            'name',
            'image',
            'sort_order',
            'level',
        ]);

        $this->template = 'pages.option_values.index';

        return $this->renderOutput([
            'optionValues' => $optionValues,
            'breadcrumbs' => $breadcrumbs,
            'parent_id' => $id,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new OptionValue.
     */
    public function create()
    {
        $parent_id = request()->input('parent_id');

        $parent = is_numeric($parent_id) ? $this->optionValueRepository->find($parent_id) : null;

        if (empty($parent) && !is_null($parent_id)) {
            Flash::error('Parent element not found');

            return redirect(route('optionValues.index'));
        }

        $languages = $this->languageRepository->getAvailableLanguages();
        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            OptionValue::class,
            OptionValueDescription::class
        ]);

        $this->template = 'pages.option_values.create';

        return $this->renderOutput(['languages' => $languages, 'fields' => $fields, 'parent_id' => $parent_id]);
    }

    /**
     * Store a newly created OptionValue in storage.
     */
    public function store(CreateOptionValueRequest $request)
    {
        $input = $request->all();

        $optionValue = $this->optionValueRepository->create($input);

        Flash::success('Option Value saved successfully.');

        return redirect(route('optionValues.index'));
    }

    /**
     * Display the specified OptionValue.
     */
    public function show(Request $request, $id)
    {
        return $this->index($request, $id);
    }

    /**
     * Show the form for editing the specified OptionValue.
     */
    public function edit($id)
    {
        $languages = $this->languageRepository->getAvailableLanguages();
        $optionValue = $this->optionValueRepository->getDetails($id);
        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            OptionValue::class,
            OptionValueDescription::class
        ]);

        if (empty($optionValue)) {
            Flash::error('Option Value not found');

            return redirect(route('optionValues.index'));
        }

        $this->template = 'pages.option_values.edit';

        return $this->renderOutput(compact('optionValue', 'fields', 'languages'));
    }

    /**
     * Update the specified OptionValue in storage.
     */
    public function update($id, UpdateOptionValueRequest $request)
    {
        $optionValue = $this->optionValueRepository->find($id);

        if (empty($optionValue)) {
            Flash::error('Option Value not found');

            return redirect(route('optionValues.index'));
        }

        $optionValue = $this->optionValueRepository->upsert($request->all(), $id);

        Flash::success('Option Value updated successfully.');

        return redirect(route('optionValues.index'));
    }

    /**
     * Remove the specified OptionValue from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $optionValue = $this->optionValueRepository->find($id);

        if (empty($optionValue)) {
            Flash::error('Option Value not found');

            return redirect(route('optionValues.index'));
        }

        $this->optionValueRepository->delete($id);

        Flash::success('Option Value deleted successfully.');

        return redirect(route('optionValues.index'));
    }
}
