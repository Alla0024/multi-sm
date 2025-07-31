<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateNewsCategoryRequest;
use App\Http\Requests\UpdateNewsCategoryRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\NewsCategoryDescription;
use App\Repositories\LanguageRepository;
use App\Repositories\NewsCategoryRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\NewsCategory;
use Flash;

class NewsCategoryController extends AppBaseController
{
    /**
     * @var NewsCategoryRepository $newsCategoryRepository
     * @var LanguageRepository $languageRepository
     * */
    private $newsCategoryRepository;
    private $languageRepository;

    public function __construct(NewsCategoryRepository $newsCategoryRepo, LanguageRepository $languageRepo)
    {
        parent::__construct();

        $this->newsCategoryRepository = $newsCategoryRepo;
        $this->languageRepository = $languageRepo;
    }

    /**
     * Display a listing of the NewsCategory.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $newsCategories = $this->newsCategoryRepository->paginate($perPage);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            NewsCategory::class,
            NewsCategoryDescription::class
        ]);

        $this->template = 'pages.news_categories.index';

        return $this->renderOutput([
            'newsCategories' => $newsCategories,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new NewsCategory.
     */
    public function create()
    {
        $this->template = 'pages.news_categories.create';
        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            NewsCategory::class,
            NewsCategoryDescription::class
        ]);
        return $this->renderOutput([
            'fields' => $fields,
            'inTabs' => array_unique(array_column($fields, 'inTab')),
        ]);
    }

    /**
     * Store a newly created NewsCategory in storage.
     */
    public function store(CreateNewsCategoryRequest $request)
    {
        $input = $request->all();

        $newsCategory = $this->newsCategoryRepository->create($input);

        Flash::success('News Category saved successfully.');

        return redirect(route('newsCategories.index'));
    }

    /**
     * Display the specified NewsCategory.
     */
    public function show($id)
    {
        $newsCategory = $this->newsCategoryRepository->find($id);
        $languages = $this->languageRepository->all();

        if (empty($newsCategory)) {
            Flash::error('News Category not found');

            return redirect(route('newsCategories.index'));
        }

        $this->template = 'pages.news_categories.show';

        return $this->renderOutput(compact('newsCategory', 'languages'));
}

    /**
     * Show the form for editing the specified NewsCategory.
     */
    public function edit($id)
    {
        $newsCategory = $this->newsCategoryRepository->find($id);

        if (empty($newsCategory)) {
            Flash::error('News Category not found');

            return redirect(route('newsCategories.index'));
        }
        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            NewsCategory::class,
            NewsCategoryDescription::class
        ]);
        $this->template = 'pages.news_categories.edit';

        return $this->renderOutput([
            'newsCategory' => $newsCategory,
            'fields' => $fields,
            'inTabs' => array_unique(array_column($fields, 'inTab')),
        ]);
    }

    /**
     * Update the specified NewsCategory in storage.
     */
    public function update($id, UpdateNewsCategoryRequest $request)
    {
        $newsCategory = $this->newsCategoryRepository->find($id);

        if (empty($newsCategory)) {
            Flash::error('News Category not found');

            return redirect(route('newsCategories.index'));
        }

        $newsCategory = $this->newsCategoryRepository->update($request->all(), $id);

        Flash::success('News Category updated successfully.');

        return redirect(route('newsCategories.index'));
    }

    /**
     * Remove the specified NewsCategory from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $newsCategory = $this->newsCategoryRepository->find($id);

        if (empty($newsCategory)) {
            Flash::error('News Category not found');

            return redirect(route('newsCategories.index'));
        }

        $this->newsCategoryRepository->delete($id);

        Flash::success('News Category deleted successfully.');

        return redirect(route('newsCategories.index'));
    }
}
