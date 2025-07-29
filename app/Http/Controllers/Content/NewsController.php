<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\FirstPathQuery;
use App\Models\NewsDescription;
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
     */
    private $newsRepository;
    private $languageRepository;

    public function __construct(NewsRepository $newsRepo, LanguageRepository $languageRepository)
    {
        parent::__construct();

        $this->newsRepository = $newsRepo;
        $this->languageRepository = $languageRepository;
    }

    /**
     * Display a listing of the News.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $languages = $this->languageRepository->all();
        $news = $this->newsRepository->paginateIndexPage($perPage, 5);

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

        Flash::success('News saved successfully.');

        return redirect(route('news.index'));
    }

    /**
     * Display the specified News.
     */
    public function show($id)
    {
        $new = $this->newsRepository->show($id);

        if (empty($new)) {
            Flash::error('News not found');

            return redirect(route('news.index'));
        }

        $this->template = 'pages.news.show';

        return $this->renderOutput(compact('new'));
    }

    /**
     * Show the form for editing the specified News.
     */
    public function edit($id)
    {
        $languages = $this->languageRepository->all();
        $news = $this->newsRepository->find($id);

        if (empty($news)) {
            Flash::error('News not found');

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
            'inTabs' => array_unique(array_column($fields, 'inTab')),
        ]);
    }

    /**
     * Update the specified News in storage.
     */
    public function update($id, UpdateNewsRequest $request)
    {
        $news = $this->newsRepository->find($id);

        if (empty($news)) {
            Flash::error('News not found');

            return redirect(route('news.index'));
        }

        $news = $this->newsRepository->update($request->all(), $id);

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
            Flash::error('News not found');

            return redirect(route('news.index'));
        }

        $this->newsRepository->delete($id);

        Flash::success('News deleted successfully.');

        return redirect(route('news.index'));
    }
}
