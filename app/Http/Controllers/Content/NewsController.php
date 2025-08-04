<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\ArticleAuthor;
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
    private $newsRepository;
    private $languageRepository;
    private $articleAuthorRepository;
    private $DEFAULT_LANGUAGE_ID;

    public function __construct(
        NewsRepository $newsRepo,
        LanguageRepository $languageRepository,
        ArticleAuthorRepository $articleAuthorRepository
    )
    {
        parent::__construct();

        $this->newsRepository = $newsRepo;
        $this->languageRepository = $languageRepository;
        $this->articleAuthorRepository = $articleAuthorRepository;
        $this->DEFAULT_LANGUAGE_ID = config('settings.locale.default_language_id');
    }

    /**
     * Display a listing of the News.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $languages = $this->languageRepository->all();
        $news = $this->newsRepository->paginateIndexPage($perPage, $this->DEFAULT_LANGUAGE_ID, $request->all());

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            NewsDescription::class,
            News::class,
        ]);

        $this->template = 'pages.news.index';

        return $this->renderOutput([
            'news' => $news,
            'languages' => $languages,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new News.
     */
    public function create()
    {
        $this->template = 'pages.news.create';
        $languages = $this->languageRepository->all();
        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            NewsDescription::class,
            News::class,
            FirstPathQuery::class
        ]);
        return $this->renderOutput([
            'fields' => $fields,
            'languages' => $languages,
            'inTabs' => array_unique(array_column($fields, 'inTab')),
        ]);
    }

    /**
     * Store a newly created News in storage.
     */
    public function store(CreateNewsRequest $request)
    {
        $input = $request->all();

        $new = $this->newsRepository->create($input);

        Flash::success(__('news.success_news_saved'));

        return redirect(route('news.index'));
    }

    /**
     * Display the specified News.
     */
    public function show($id)
    {
        $news = $this->newsRepository->find($id);
        $languages = $this->languageRepository->all();

        if (empty($news)) {
            Flash::error(__('news.error_news_not_found'));

            return redirect(route('news.index'));
        }

        $this->template = 'pages.news.show';

        return $this->renderOutput(compact('news', 'languages'));
    }

    /**
     * Show the form for editing the specified News.
     */
    public function edit($id)
    {
        $languages = $this->languageRepository->all();
        $news = $this->newsRepository->find($id);
        $authors = $this->articleAuthorRepository->getAuthorIdNameMap($this->DEFAULT_LANGUAGE_ID);

        if (empty($news)) {
            Flash::error(__('news.error_news_not_found'));

            return redirect(route('news.index'));
        }

        $seoUrl = FirstPathQuery::where('type_id', $id)->where('type', 'news')->value('path');
        $news->setAttribute('path', $seoUrl);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            News::class,
            FirstPathQuery::class,
            NewsDescription::class,
        ]);

        $this->template = 'pages.news.edit';

        return $this->renderOutput([
            'news' => $news,
            'fields' => $fields,
            'languages' => $languages,
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
            Flash::error(__('news.error_news_not_found'));

            return redirect(route('news.index'));
        }

        $news = $this->newsRepository->update($dto, $id);

        Flash::success('News updated successfully.');

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
            Flash::error(__('news.error_news_not_found'));

            return redirect(route('news.index'));
        }

        $this->newsRepository->delete($id);

        Flash::success(__('news.success_news_deleted'));

        return redirect(route('news.index'));
    }
}
