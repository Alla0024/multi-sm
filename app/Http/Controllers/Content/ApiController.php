<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\AppBaseController;
use App\Repositories\ArticleAuthorRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\NewsCategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends AppBaseController
{
    /**
     * @var CategoryRepository $categoryRepository;
     * @var NewsCategoryRepository $newsCategoryRepository;
     * @var ArticleAuthorRepository $articleAuthorRepository;
     * @var ProductRepository $productRepository
     * @var String $DEFAULT_LANGUAGE_ID;
     */
    private $categoryRepository;
    private $newsCategoryRepository;
    private $articleAuthorRepository;
    private $productRepository;
    private $defaultLanguageId;

    public function __construct(
        CategoryRepository $categoryRepo,
        NewsCategoryRepository $newsCategoryRepo,
        ArticleAuthorRepository $articleAuthorRepo,
        ProductRepository $productRepo,
    )
    {
        parent::__construct();

        $this->categoryRepository = $categoryRepo;
        $this->newsCategoryRepository = $newsCategoryRepo;
        $this->articleAuthorRepository = $articleAuthorRepo;
        $this->productRepository = $productRepo;

        $this->defaultLanguageId = config('settings.locale.default_language_id');
    }

    public function getCategories(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $data = $this->categoryRepository->getDropdownItems($this->defaultLanguageId, request()->all());

            return response()->json(['items' => $data ?? []]);
        } else {
            return abort(404);
        }
    }

    public function getNewsCategories(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $data = $this->newsCategoryRepository->getDropdownItems($this->defaultLanguageId, $request->all());

            return response()->json(['items' => $data ?? []]);
        } else {
            return abort(404);
        }
    }

    public function getAuthors(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $data = $this->articleAuthorRepository->getDropdownItems($this->defaultLanguageId, $request->all());

            return response()->json(['items' => $data ?? []]);
        } else {
            return abort(404);
        }
    }

    /**
     * Available params:
     * q
     * manufacturer_id
     * category_id
     * products_id
     */
    public function getProducts(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $data = $this->productRepository->getDropdownItems($this->defaultLanguageId, request()->all());

            return response()->json(['items' => $data]);
        } else {
            return abort(404);
        }
    }
}
