<?php

namespace App\Repositories;

use App\Models\FirstPathQuery;
use App\Models\News;
use App\Models\NewsDescription;
use App\Models\NewsToNewsCategory;
use App\Repositories\BaseRepository;
use Illuminate\Container\Container as Application;
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

    public function model(): string
    {
        return News::class;
    }

    public function getDetails($id, $language_id)
    {
        $news = $this->model->with([
            'descriptions',
            'seoPath' => function($query) {
                $query->select('type', 'type_id', 'path');
            },
            'author.descriptions' => function($query) use ($language_id) {
                $query->where('language_id', $language_id);
            },
            'category.descriptions' => function($query) use ($language_id) {
                $query->where('language_id', $language_id);
            },
            'newsCategories.descriptions' => function($query) use ($language_id) {
                $query->where('language_id', $language_id);
            },
        ])->find($id);

        $products = $this->newsToProductRepository->getProductsDropdownByNewsId($id, $language_id);

        $preshaped_descriptions = [];
        $preshaped_news_categories = [];
        $seo_path = $news->seoPath?->path;
        $category = $news->category->descriptions->first();
        $author = $news->author->descriptions->first();
        $preshaped_category = [ 'id' => $category->category_id, 'text' => $category->name ];
        $preshaped_author = [ 'id' => $author->author_id, 'text' => $author->name ];

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
        );

        $news->setAttribute('news_categories', $preshaped_news_categories);
        $news->setAttribute('category_id', $preshaped_category);
        $news->setAttribute('author_id', $preshaped_author);
        $news->setAttribute('descriptions', $preshaped_descriptions);
        $news->setAttribute('path', $seo_path);
        $news->setAttribute('products', $products);

        return $news;
    }

    public function filterIndexPage($perPage, $language_id, $params)
    {
        $news = $this->model
            ->leftJoin((new NewsDescription())->getTable() . " as nd", 'nd.news_id', '=', 'news.id')
            ->where('nd.language_id', $language_id)
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
        $this->firstPathQueryRepository->upsert($news->id, 'news', $seoPath);
        $this->newsToNewsCategoryRepository->sync($news->id, $newsCategories);
        $this->newsToProductRepository->sync($news->id, $products);

        return $news;
    }

    public function delete($id) {
        $news = $this->find($id);

        $this->firstPathQueryRepository->destroy($news->id, 'news');
        $news->delete();
    }
}
