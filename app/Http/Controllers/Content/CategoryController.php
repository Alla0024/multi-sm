<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\CategoryDescription;
use App\Repositories\CategoryRepository;
use App\Helpers\ModelSchemaHelper;
use App\Repositories\FilterRepository;
use Illuminate\Http\Request;
use App\Models\Category;
use Flash;

class CategoryController extends AppBaseController
{
    /** @var CategoryRepository $categoryRepository*/
    private $categoryRepository;
    /** @var FilterRepository $filterRepository*/
    private $filterRepository;

    public function __construct(CategoryRepository $categoryRepo, FilterRepository $filterRepo)
    {
        parent::__construct();

        $this->categoryRepository = $categoryRepo;
        $this->filterRepository = $filterRepo;
    }

    /**
     * Display a listing of the Category.
     */
    public function index(Request $request)
    {
        $categories = $this->categoryRepository->filterRows($request);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            CategoryDescription::class,
            Category::class,
        ]);

        $this->template = 'pages.categories.index';

        return $this->renderOutput([
            'categories' => $categories,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new Category.
     */
    public function create()
    {
        $this->template = 'pages.categories.create';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            CategoryDescription::class,
            Category::class,
        ]);
        return $this->renderOutput([
            'fields' => $fields,
        ]);
    }

    /**
     * Store a newly created Category in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        $input = $request->all();

        $category = $this->categoryRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('categories.index'));
    }

    /**
     * Display the specified Category.
     */
    public function show($id)
    {
        $category = $this->categoryRepository->findFull($id);

        if (empty($category)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('categories.index'));
        }

        $this->template = 'pages.categories.show';

        return $this->renderOutput(compact('category'));
}

    /**
     * Show the form for editing the specified Category.
     */
    public function edit($id)
    {
        $category = $this->categoryRepository->findFull($id);
        $activeCategories = $this->categoryRepository->getActiveCategories();
        $categories = $this->categoryRepository->buildTree($id);

        $filters = $this->filterRepository->getFiltersByCategoryId($id);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            CategoryDescription::class,
            Category::class,
        ]);

        if (empty($category)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('categories.index'));
        }

        $this->template = 'pages.categories.edit';

        return $this->renderOutput(compact('category', 'categories', 'activeCategories', 'filters', 'fields'));
    }

    /**
     * Update the specified Category in storage.
     */
    public function update($id, UpdateCategoryRequest $request)
    {
        $category = $this->categoryRepository->find($id);

        if (empty($category)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('categories.index'));
        }

        $category = $this->categoryRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified Category from storage.
     *
     * @throws \Exception
     */
    public function destroy($ids)
    {
       $this->categoryRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('categories.index'));
    }
    public function copy(Request $request)
    {
        $ids = $request->input('category_ids');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->categoryRepository->copy($ids);

            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('categories.index');
        }

        Flash::error(__('common.flash_error'));

        return redirect()->route('categories.index');
    }
}
