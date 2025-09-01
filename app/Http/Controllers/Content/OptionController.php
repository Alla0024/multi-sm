<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateOptionRequest;
use App\Http\Requests\UpdateOptionRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\OptionDescription;
use App\Repositories\CategoryRepository;
use App\Repositories\LanguageRepository;
use App\Repositories\OptionRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\Option;
use Flash;

class OptionController extends AppBaseController
{
    /**
     * @var OptionRepository $optionRepository
     * @var LanguageRepository $languageRepository
     * @var CategoryRepository $categoryRepository
     */
    private OptionRepository $optionRepository;
    private CategoryRepository $categoryRepository;
    private LanguageRepository $languageRepository;
    private int $defaultLanguageId;

    public function __construct(
        OptionRepository   $optionRepo,
        LanguageRepository $languageRepo,
        CategoryRepository $categoryRepo,
    )
    {
        parent::__construct();

        $this->optionRepository = $optionRepo;
        $this->languageRepository = $languageRepo;
        $this->categoryRepository = $categoryRepo;
        $this->defaultLanguageId = config('settings.locale.default_language_id');
    }

    /**
     * Display a listing of the Option.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $sortFields = [
            'default',
            'name_asc',
            'name_desc',
            'created_at_asc',
            'created_at_desc',
        ];

        $languageId = $request->get('language_id') ?? $this->defaultLanguageId;
        $options = $this->optionRepository->filterIndexPage($perPage, $languageId, request()->all());
        $categories = $this->categoryRepository->getDropdownItems($languageId);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Option::class
        ], [
            'name',
            'sort_order',
            'appears_in_categories',
            'value_groups_count',
        ]);

        $this->template = 'pages.options.index';

        return $this->renderOutput([
            'options' => $options,
            'categories' => $categories,
            'sortFields' => $sortFields,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new Option.
     */
    public function create()
    {
        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            OptionDescription::class,
            Option::class
        ]);

        $this->template = 'pages.options.create';

        return $this->renderOutput(['fields' => $fields]);
    }

    /**
     * Store a newly created Option in storage.
     */
    public function store(CreateOptionRequest $request)
    {
        $input = $request->all();

        $option = $this->optionRepository->upsert($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('options.index'));
    }

    /**
     * Display the specified Option.
     */
    public function show($id)
    {
        $option = $this->optionRepository->find($id);

        if (empty($option)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('options.index'));
        }

        $this->template = 'pages.options.show';

        return $this->renderOutput(compact('option'));
    }

    /**
     * Show the form for editing the specified Option.
     */
    public function edit($id)
    {
        $option = $this->optionRepository->getDetails($id);
        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            OptionDescription::class,
            Option::class
        ]);

        if (empty($option)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('options.index'));
        }

        $this->template = 'pages.options.edit';

        return $this->renderOutput(compact('option', 'fields'));
    }

    /**
     * Update the specified Option in storage.
     */
    public function update($id, UpdateOptionRequest $request)
    {
        $option = $this->optionRepository->find($id);

        if (empty($option)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('options.index'));
        }

        $option = $this->optionRepository->upsert($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        return redirect(route('options.index'));
    }

    /**
     * Remove the specified Option from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $option = $this->optionRepository->find($id);

        if (empty($option)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('options.index'));
        }

        $this->optionRepository->delete($id);

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('options.index'));
    }
}
