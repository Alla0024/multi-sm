<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\AppBaseController;
use App\Models\Attribute;
use App\Models\AttributeGroup;
use App\Models\Filter;
use App\Models\Language;
use App\Models\NewDescription;
use App\Models\NewsDescription;
use App\Models\OptionValueGroup;
use App\Models\Product;
use App\Repositories\ArticleAuthorRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\LocationRepository;
use App\Repositories\NewsCategoryRepository;
use App\Repositories\ProductRepository;
use App\Repositories\StoreRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends AppBaseController
{
    /**
     * @var CategoryRepository $categoryRepository;
     * @var NewsCategoryRepository $newsCategoryRepository;
     * @var ArticleAuthorRepository $articleAuthorRepository;
     * @var ProductRepository $productRepository
     * @var StoreRepository $storeRepository
     * @var LocationRepository $locationRepository
     * @var String $DEFAULT_LANGUAGE_ID;
     */
    private CategoryRepository $categoryRepository;
    private NewsCategoryRepository $newsCategoryRepository;
    private ArticleAuthorRepository $articleAuthorRepository;
    private ProductRepository $productRepository;
    private StoreRepository $storeRepository;
    private LocationRepository $locationRepository;
    private String $defaultLanguageId;

    public function __construct(
        CategoryRepository $categoryRepo,
        NewsCategoryRepository $newsCategoryRepo,
        ArticleAuthorRepository $articleAuthorRepo,
        ProductRepository $productRepo,
        StoreRepository $storeRepo,
        LocationRepository $locationRepo
    )
    {
        parent::__construct();

        $this->categoryRepository = $categoryRepo;
        $this->newsCategoryRepository = $newsCategoryRepo;
        $this->articleAuthorRepository = $articleAuthorRepo;
        $this->productRepository = $productRepo;
        $this->storeRepository = $storeRepo;
        $this->locationRepository = $locationRepo;

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

    public function getStores(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $data = $this->storeRepository->getDropdownItems($this->defaultLanguageId, $request->all());

            return response()->json(['items' => $data ?? []]);
        } else {
            return abort(404);
        }
    }

    public function getLocations(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            $data = $this->locationRepository->getDropdownItems($this->defaultLanguageId, $request->all());

            return response()->json(['items' => $data ?? []], 200);
        } else {
            return abort(404);
        }
    }
    public function getOptionToFilter(Request $request)
    {
        if ($request->ajax()) {

            $filters = $request->has('group_id')
                ? Filter::with(['description'])
                    ->where('filter_group_id', 1)
                    ->get()
                : null;

            if (isset($_GET['option_id'])) {
                $option_id = $_GET['option_id'];
                $option_values = OptionValueGroup::where('option_id', $option_id)->with('description')->get();
                return response()->json(['option_values' => $option_values, 'filters' => $filters, 'words' => $this->vars['word'], 'languages' => $languages]);
            }

            return response()->json(['filters' => $filters ]);
        } else {
            return abort(404);
        }
    }
    public function getAttributes(Request $request)
    {
        $attributes = Attribute::with('description')->get();

        $attribute_groups = AttributeGroup::with('description')->get();

        $languages = Language::getLanguages();

        if ($request->ajax()) {
            return response()->json([
                'attributes' => $attributes,
                'attribute_groups' => $attribute_groups,
                'languages' => $languages,
                'words' => $this->vars['word'],
            ]);
        }

        return abort(404);
    }
    public function getNews(Request $request)
    {
        if (! $request->ajax()) {
            return abort(404);
        }

        $articles = NewsDescription::selectRaw('news_id, MIN(title) as title')
            ->where('title', 'LIKE', '%' . $request->q . '%')
            ->groupBy('news_id')
            ->paginate(10);

        $data = $articles->map(function ($article) {
            return [
                'id'   => $article->news_id,
                'text' => $article->title,
            ];
        });

        return response()->json(['items' => $data]);
    }

    public function getProduct(Request $request)
    {
        if (! $request->ajax()) {
            return abort(404);
        }

        $query = Product::with('description')
            ->where('status', 1)
            ->where('stock_status_id', 7)
            ->where(function ($q) use ($request) {
                $search = $request->q;
                if (is_numeric($search)) {
                    $q->where('article', 'LIKE', "%{$search}%");
                } else {
                    $q->whereHas('description', function ($subQuery) use ($search) {
                        $subQuery->where('name', 'LIKE', "%{$search}%");
                    });
                }
            });

        $products = $query->paginate(10);

        $data = $products->map(function ($product) {
            return [
                'id'   => $product->id,
                'text' => $product->description?->name ?? '',
            ];
        });

        return response()->json(['items' => $data]);
    }
}
