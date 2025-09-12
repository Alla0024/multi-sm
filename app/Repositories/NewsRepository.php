<?php

namespace App\Repositories;

use App\Models\FirstPathQuery;
use App\Models\News;
use App\Models\NewsDescription;
use App\Models\NewsToNewsCategory;
use App\Models\NewsToProduct;
use App\Repositories\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Http\Request;
use function Laravel\Prompts\select;

class NewsRepository extends BaseRepository
{
    /**
     * @var NewsToProductRepository $newsToProductRepository;
     * @var NewsToNewsCategoryRepository $newsToNewsCategoryRepository;
     * @var NewsDescriptionRepository $newsDescriptionRepository;
     * @var FirstPathQueryRepository $firstPathQueryRepository
     */
    private $newsToProductRepository;
    private $newsToNewsCategoryRepository;
    private $newsDescriptionRepository;
    private $firstPathQueryRepository;

    protected $fieldSearchable = [
        'sort_order',
        'status'
    ];

    protected $additionalFields = [
        'news_categories'
    ];

    public function __construct(
        Application $app,
        NewsToProductRepository $newsToProductRepo,
        NewsToNewsCategoryRepository $newsToNewsCategoryRepo,
        NewsDescriptionRepository $newsDescriptionRepo,
        FirstPathQueryRepository $firstPathQueryRepo
    ) {
        parent::__construct($app);

        $this->newsToProductRepository = $newsToProductRepo;
        $this->newsToNewsCategoryRepository = $newsToNewsCategoryRepo;
        $this->newsDescriptionRepository = $newsDescriptionRepo;
        $this->firstPathQueryRepository = $firstPathQueryRepo;
    }

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function getAdditionalFields(): array
    {
        return $this->additionalFields;
    }

    public function model(): string
    {
        return News::class;
    }

    public function findFull($id)
    {
        $news = $this->model->with([
            'descriptions',
            'seoPath' => function($query) {
                $query->select('type', 'type_id', 'path');
            },
            'author.descriptions' => function($query) {
                $query->where('language_id', config('settings.locale.default_language_id'));
            },
            'category.descriptions'=> function($query) {
                $query->where('language_id', config('settings.locale.default_language_id'));
            },
            'newsCategories.descriptions' => function($query) {
                $query->where('language_id', config('settings.locale.default_language_id'));
            },
        ])->find($id);

        $products = $this->newsToProductRepository->getProductsDropdownByNewsId($id);

        $seo_path = $news->seoPath?->path;
        $category = $news->category->descriptions->first();
        $author = $news->author->descriptions->first();

        $preshaped_descriptions = [];
        $preshaped_news_categories = [];
        $preshaped_category = [ 'id' => $category->category_id, 'text' => $category->name ];
        $preshaped_author = [ 'id' => $author->author_id, 'text' => $author->name ];
        $preshaped_created_at = $news->created_at->toDateString();
        $preshaped_updated_at = $news->updated_at->toDateString();

        foreach ($news->descriptions as $description) {
            $preshaped_descriptions[$description->language->id] = [
                'title' => $description->title,
                'description' => $description->description,
                'meta_h1' => $description->meta_h1,
                'meta_title' => $description->meta_title,
                'meta_description' => $description->meta_description,
                'meta_keyword' => $description->meta_keyword,
                'products_title' => $description->products_title,
            ];
        }

        foreach ($news->newsCategories as $news_category) {
            $preshaped_news_categories[] = [
                'id' => $news_category->id,
                'text' => $news_category->descriptions->first()->name
            ];
        }

        unset(
            $news->seoPath,
            $news->category,
            $news->author,
            $news->updated_at,
            $news->created_at
        );

        $news->setAttribute('news_categories', $preshaped_news_categories);
        $news->setAttribute('category_id', $preshaped_category);
        $news->setAttribute('author_id', $preshaped_author);
        $news->setAttribute('descriptions', $preshaped_descriptions);
        $news->setAttribute('path', $seo_path);
        $news->setAttribute('products', $products);
        $news->setAttribute('created_at', $preshaped_created_at);
        $news->setAttribute('updated_at', $preshaped_updated_at);

        return $news;
    }

    public function filterRows(Request $request)
    {
        $perPage    = $request->integer('perPage', 10);
        $languageId = $request->input('language_id', config('settings.locale.default_language_id'));
        $params = $request->all();

        $news = $this->model
            ->leftJoin((new NewsDescription())->getTable() . " as nd", 'nd.news_id', '=', 'news.id')
            ->where('nd.language_id', $languageId)
            ->with(['seoPath' => function($query) {
                $query->select('type', 'type_id', 'path');
            }])
            ->when(isset($params['sort_order']), function ($query) use ($params) {
                $query->where('sort_order', '=', $params['sort_order']);
            })
            ->when(isset($params['status']), function ($query) use ($params) {
                $query->where('status', '=', $params['status']);
            })
            ->when(isset($params['title']), function ($q) use ($params) {
                return $q->searchSimilarity(['nd.title'], $params['title']);
            })
            ->when(isset($params['sortBy']), function ($query) use ($params) {
                switch ($params['sortBy']) {
                    case 'name_asc':
                        $query->orderBy('nd.title', 'asc');
                        break;
                    case 'name_desc':
                        $query->orderBy('nd.title', 'desc');
                        break;
                    case 'created_at':
                        $query->orderBy('created_at', 'asc');
                        break;
                    case 'created_at_desc':
                        $query->orderBy('created_at', 'desc');
                        break;
                    default:
                        break;
                }

                return $query;
            })
            ->paginate($perPage, ['nd.title', 'sort_order', 'status', 'id', 'created_at', 'updated_at']);

        $news->each(function ($item) {
            if ($item->seoPath) {
                $baseUrl = config('app.client_url');
                $path = $item->seoPath->path;

                $item->setAttribute('client_url', rtrim($baseUrl, '/') . '/' . ltrim($path, '/'));
            }
        });

        return $news;
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function upsert(array $input, $id = null)
    {
        $descriptions = $input['descriptions'] ?? [];
        $seoPath = $input['path'];
        $newsCategories = $input['news_categories'] ?? [];
        $products = $input['products'] ?? [];
        unset($input['descriptions'], $input['path'], $input['news_categories']);

        $news = isset($id) ? $this->model->find($id) : null;

        if (!$news) {
            $news = new $this->model();
        }

        $news->fill($input);
        $news->save();

        $this->newsDescriptionRepository->upsert($news->id, $descriptions);
        $this->firstPathQueryRepository->save($news->id, 'news', $seoPath);
        $this->newsToNewsCategoryRepository->sync($news->id, $newsCategories);
        $this->newsToProductRepository->sync($news->id, $products);

        return $news;
    }

    public function delete($id) {
        $news = $this->find($id);

        $this->firstPathQueryRepository->destroy($news->id, 'news');
        $news->delete();
    }

    public function copy($ids): void
    {
        $news = News::whereIn('id', $ids)->get();

        foreach ($news as $item) {
            $newItem = $item->replicate();
            $newItem->status = 0;
            $newItem->save();

            $newsDescriptions = NewsDescription::where('news_id', $item->id)
                ->get()
                ->keyBy('language_id')
                ->each(function ($item) {
                    unset($item->news_id);
                })
                ->toArray();

            $newsCategories = NewsToNewsCategory::where('news_id', $item->id)
                ->get()
                ->pluck('news_category_id')
                ->toArray();

            $products = NewsToProduct::where('news_id', $item->id)
                ->get()
                ->each(function ($item) {
                    $product_id = $item->product_id;
                    $item->setAttribute('id', $product_id);
                    unset($item->news_id, $item->product_id);
                })
                ->toArray();

            $this->newsDescriptionRepository->upsert($newItem->id, $newsDescriptions);
            $this->newsToNewsCategoryRepository->sync($newItem->id, $newsCategories);
            $this->newsToProductRepository->sync($newItem->id, $products);
        }
    }

    public function multiDelete($ids): void
    {
        News::whereIn('id', $ids)->delete();
        NewsDescription::whereIn('news_id', $ids)->delete();
        FirstPathQuery::where('type', 'news')->whereIn('type_id', $ids)->delete();
    }
}
