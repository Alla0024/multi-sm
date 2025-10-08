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
     * @var CategoryRepository $categoryRepository
     */
    private OptionRepository $optionRepository;
    private CategoryRepository $categoryRepository;

    public function __construct(
        OptionRepository   $optionRepo,
        CategoryRepository $categoryRepo,
    )
    {
        parent::__construct();

        $this->optionRepository = $optionRepo;
        $this->categoryRepository = $categoryRepo;
    }

    /**
     * Display a listing of the Option.
     */
    public function index(Request $request)
    {
        $input = $request->all();

        $options = $this->optionRepository->filterRows($input);
        $categories = $this->categoryRepository->getDropdownItems($input);

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

        $option = $this->optionRepository->save($input);

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
        $option = $this->optionRepository->findFull($id);
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

        $option = $this->optionRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        return redirect(route('options.index'));
    }

    /**
     * Remove the specified Option from storage.
     *
     * @throws \Exception
     */
    public function destroy($ids)
    {
        $this->optionRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('options.index'));
    }

    public function copy(Request $request)
    {
        $ids = $request->input('options_id');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->optionRepository->copy($ids);

            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('options.index');
        }

        Flash::error(__('common.flash_error'));

        return redirect()->route('options.index');
    }
}
