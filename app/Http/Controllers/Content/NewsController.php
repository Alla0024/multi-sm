<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\FirstPathQuery;
use App\Models\NewsDescription;
use App\Repositories\ArticleAuthorRepository;
use App\Repositories\LanguageRepository;
use App\Repositories\NewsRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\News;
use Flash;

class NewsController extends AppBaseController
{
    /**
     * @var NewsRepository $newsRepository
     * @var LanguageRepository $languageRepository
     * @var ArticleAuthorRepository $articleAuthorRepository
     */
    private NewsRepository $newsRepository;
    private ArticleAuthorRepository $articleAuthorRepository;
    public function __construct(
        NewsRepository          $newsRepo,
        ArticleAuthorRepository $articleAuthorRepository
    )
    {
        parent::__construct();

        $this->newsRepository = $newsRepo;
        $this->articleAuthorRepository = $articleAuthorRepository;
    }

    /**
     * Display a listing of the News.
     */
    public function index(Request $request)
    {
        $news = $this->newsRepository->filterIndexPage( $request->all());
        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            NewsDescription::class,
            News::class,
        ]);

        $this->template = 'pages.news.index';

        return $this->renderOutput([
            'news' => $news,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new News.
     */
    public function create()
    {
        $this->template = 'pages.news.create';
        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            NewsDescription::class,
            News::class,
            FirstPathQuery::class
        ]);
        return $this->renderOutput([
            'fields' => $fields,
            'inTabs' => array_unique(array_column($fields, 'inTab')),
        ]);
    }

    /**
     * Store a newly created News in storage.
     */
    public function store(CreateNewsRequest $request)
    {
        $input = $request->all();

        $new = $this->newsRepository->upsert($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('news.index'));
    }

    /**
     * Display the specified News.
     */
    public function show($id)
    {
        $news = $this->newsRepository->getDetails($id, $this->defaultLanguageId);

        if (empty($news)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('news.index'));
        }

        $this->template = 'pages.news.show';

        return $this->renderOutput(compact('news'));
    }

    /**
     * Show the form for editing the specified News.
     */
    public function edit($id)
    {
        $news = $this->newsRepository->getDetails($id, $this->defaultLanguageId);
        $authors = $this->articleAuthorRepository->getAuthorIdNameMap($this->defaultLanguageId);

        if (empty($news)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('news.index'));
        }

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            News::class,
            FirstPathQuery::class,
            NewsDescription::class,
        ]);

        $this->template = 'pages.news.edit';

        return $this->renderOutput([
            'news' => $news,
            'fields' => $fields,
            'authors' => $authors,
            'inTabs' => array_unique(array_column($fields, 'inTab')),
        ]);
    }

    /**
     * Update the specified News in storage.
     */
    public function update($id, UpdateNewsRequest $request)
    {
        $dto = $request->all();
        $news = $this->newsRepository->find($id);

        if (empty($news)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('news.index'));
        }

        $news = $this->newsRepository->upsert($dto, $id);

        Flash::success(__('common.flash_updated_successfully'));

        return redirect(route('news.index'));
    }

    /**
     * Remove the specified News from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $new = $this->newsRepository->find($id);

        if (empty($new)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('news.index'));
        }

        $this->newsRepository->delete($id);

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('news.index'));
    }
}
