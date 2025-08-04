<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\AppBaseController;
use App\Repositories\ArticleAuthorRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\NewsCategoryRepository;
use Illuminate\Http\Request;

class ApiController extends AppBaseController
{
    /**
     * @var CategoryRepository $categoryRepository;
     * @var NewsCategoryRepository $newsCategoryRepository;
     * @var ArticleAuthorRepository $articleAuthorRepository;
     * @var String $DEFAULT_LANGUAGE_ID;
     */
    private $categoryRepository;
    private $newsCategoryRepository;
    private $articleAuthorRepository;
    private $DEFAULT_LANGUAGE_ID;

    public function __construct(
        CategoryRepository $categoryRepo,
        NewsCategoryRepository $newsCategoryRepo,
        ArticleAuthorRepository $articleAuthorRepo,
    )
    {
        parent::__construct();

        $this->categoryRepository = $categoryRepo;
        $this->newsCategoryRepository = $newsCategoryRepo;
        $this->articleAuthorRepository = $articleAuthorRepo;

        $this->DEFAULT_LANGUAGE_ID = config('settings.locale.default_language_id');
    }

    public function getCategories(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->categoryRepository->getIdNameMap($this->DEFAULT_LANGUAGE_ID);

            return response()->json(['items' => $data ?? []]);
        } else {
            return abort(404);
        }
    }

    public function getNewsCategories(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->newsCategoryRepository->getIdNameMap($this->DEFAULT_LANGUAGE_ID);

            return response()->json(['items' => $data ?? []]);
        } else {
            return abort(404);
        }
    }

    public function getAuthors(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->articleAuthorRepository->getIdNameMap($this->DEFAULT_LANGUAGE_ID);

            return response()->json(['items' => $data ?? []]);
        } else {
            return abort(404);
        }
    }
}
