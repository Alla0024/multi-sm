<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateNewsToNewsCategoryRequest;
use App\Http\Requests\UpdateNewsToNewsCategoryRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\NewsToNewsCategoryRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\NewsToNewsCategory;
use Flash;

class NewsToNewsCategoryController extends AppBaseController
{
    /** @var NewsToNewsCategoryRepository $newsToNewsCategoryRepository*/
    private $newsToNewsCategoryRepository;

    public function __construct(NewsToNewsCategoryRepository $newsToNewsCategoryRepo)
    {
        parent::__construct();

        $this->newsToNewsCategoryRepository = $newsToNewsCategoryRepo;
    }

    /**
     * Display a listing of the NewsToNewsCategory.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $newsToNewsCategories = $this->newsToNewsCategoryRepository->paginate($perPage);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            NewsToNewsCategory::class
        ]);

        $this->template = 'pages.news_to_news_categories.index';

        return $this->renderOutput([
            'newsToNewsCategories' => $newsToNewsCategories,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new NewsToNewsCategory.
     */
    public function create()
    {
        $this->template = 'pages.news_to_news_categories.create';

        return $this->renderOutput();
    }

    /**
     * Store a newly created NewsToNewsCategory in storage.
     */
    public function store(CreateNewsToNewsCategoryRequest $request)
    {
        $input = $request->all();

        $newsToNewsCategory = $this->newsToNewsCategoryRepository->create($input);

        Flash::success('News To News Category saved successfully.');

        return redirect(route('newsToNewsCategories.index'));
    }

    /**
     * Display the specified NewsToNewsCategory.
     */
    public function show($id)
    {
        $newsToNewsCategory = $this->newsToNewsCategoryRepository->find($id);

        if (empty($newsToNewsCategory)) {
            Flash::error('News To News Category not found');

            return redirect(route('newsToNewsCategories.index'));
        }

        $this->template = 'pages.news_to_news_categories.show';

        return $this->renderOutput(compact('newsToNewsCategory'));
}

    /**
     * Show the form for editing the specified NewsToNewsCategory.
     */
    public function edit($id)
    {
        $newsToNewsCategory = $this->newsToNewsCategoryRepository->find($id);

        if (empty($newsToNewsCategory)) {
            Flash::error('News To News Category not found');

            return redirect(route('newsToNewsCategories.index'));
        }

        $this->template = 'pages.news_to_news_categories.edit';

        return $this->renderOutput(compact('newsToNewsCategory'));
    }

    /**
     * Update the specified NewsToNewsCategory in storage.
     */
    public function update($id, UpdateNewsToNewsCategoryRequest $request)
    {
        $newsToNewsCategory = $this->newsToNewsCategoryRepository->find($id);

        if (empty($newsToNewsCategory)) {
            Flash::error('News To News Category not found');

            return redirect(route('newsToNewsCategories.index'));
        }

        $newsToNewsCategory = $this->newsToNewsCategoryRepository->update($request->all(), $id);

        Flash::success('News To News Category updated successfully.');

        return redirect(route('newsToNewsCategories.index'));
    }

    /**
     * Remove the specified NewsToNewsCategory from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $newsToNewsCategory = $this->newsToNewsCategoryRepository->find($id);

        if (empty($newsToNewsCategory)) {
            Flash::error('News To News Category not found');

            return redirect(route('newsToNewsCategories.index'));
        }

        $this->newsToNewsCategoryRepository->delete($id);

        Flash::success('News To News Category deleted successfully.');

        return redirect(route('newsToNewsCategories.index'));
    }
}
