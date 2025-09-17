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
     */
    private OptionValueRepository $optionValueRepository;
    private int $defaultLanguageId;

    public function __construct(OptionValueRepository $optionValueRepo)
    {
        parent::__construct();

        $this->optionValueRepository = $optionValueRepo;
        $this->defaultLanguageId = config('settings.locale.default_language_id');
    }

    /**
     * Display a listing of the OptionValue.
     */
    public function index(Request $request, $id = null)
    {
        $sortFields = [
            'default',
            'name_asc',
            'name_desc',
            'created_at_asc',
            'created_at_desc',
        ];

        $languageId = $request->get('language_id') ?? $this->defaultLanguageId;
        $optionValues = $this->optionValueRepository->filterRows($request, $id);

        $breadcrumbs = $this->optionValueRepository->getBreadCrumbsRecursive($id, $languageId);

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
            'parentId' => $id,
            'fields' => $fields,
            'sortFields' => $sortFields,
        ]);
    }


    /**
     * Show the form for creating a new OptionValue.
     */
    public function create()
    {
        $parentId = request()->input('parent_id');
        $parent = is_numeric($parentId) ? $this->optionValueRepository->find($parentId) : null;
        $valuesTree = $this->optionValueRepository->getValuesTree();
        $optionValueTypes = ['category', 'type', 'line', 'material'];

        if (empty($parent) && !is_null($parentId)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('optionValues.index'));
        }

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            OptionValue::class,
            OptionValueDescription::class
        ]);

        $this->template = 'pages.option_values.create';

        return $this->renderOutput(compact('parent', 'parentId', 'valuesTree', 'optionValueTypes', 'fields'));
    }

    /**
     * Store a newly created OptionValue in storage.
     */
    public function store(CreateOptionValueRequest $request)
    {
        $input = $request->all();

        $optionValue = $this->optionValueRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        if ($request->get('parent_id') !== null) {
            return redirect(route('optionValues.show', $request->get('parent_id')));
        }

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
        $optionValue = $this->optionValueRepository->findFull($id);
        $valuesTree = $this->optionValueRepository->getValuesTree();
        $optionValueTypes = ['category', 'type', 'line', 'material'];

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            OptionValue::class,
            OptionValueDescription::class
        ]);

        if (empty($optionValue)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('optionValues.index'));
        }

        $this->template = 'pages.option_values.edit';

        return $this->renderOutput(compact('optionValue', 'fields', 'valuesTree', 'optionValueTypes'));
    }

    /**
     * Update the specified OptionValue in storage.
     */
    public function update($id, UpdateOptionValueRequest $request)
    {
        $optionValue = $this->optionValueRepository->find($id);

        if (empty($optionValue)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('optionValues.index'));
        }

        $optionValue = $this->optionValueRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        if ($request->get('parent_id') !== null) {
            return redirect(route('optionValues.show', $request->get('parent_id')));
        }

        return redirect(route('optionValues.index'));
    }

    /**
     * Remove the specified OptionValue from storage.
     *
     * @throws \Exception
     */
    public function destroy(Request $request, $ids)
    {
        $this->optionValueRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        if ($request->get('parent_id') !== null) {
            return redirect(route('optionValues.show', $request->get('parent_id')));
        }

        return redirect(route('optionValues.index'));
    }

    public function copy(Request $request)
    {
        $ids = $request->input('optionValues_id');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->optionValueRepository->copy($ids);

            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('optionValues.index');
        }

        Flash::error(__('common.flash_error'));

        return redirect()->route('optionValues.index');
    }
}
