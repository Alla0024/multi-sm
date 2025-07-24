<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\NewsDescription;
use App\Repositories\NewsRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\News;
use Flash;

class NewsController extends AppBaseController
{
    /** @var NewsRepository $newsRepository*/
    private $newsRepository;

    public function __construct(NewsRepository $newsRepo)
    {
        parent::__construct();

        $this->newsRepository = $newsRepo;
    }

    /**
     * Display a listing of the News.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $news = $this->newsRepository->paginate($perPage);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            News::class,
            NewsDescription::class,
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
            News::class,
            NewsDescription::class,
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

        $new = $this->newsRepository->create($input);

        Flash::success('News saved successfully.');

        return redirect(route('news.index'));
    }

    /**
     * Display the specified News.
     */
    public function show($id)
    {
        $new = $this->newsRepository->find($id);

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
        $new = $this->newsRepository->find($id);

        if (empty($new)) {
            Flash::error('News not found');

            return redirect(route('news.index'));
        }
        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            News::class,
            NewsDescription::class,
        ]);
        $this->template = 'pages.news.edit';

        return $this->renderOutput([
            'new' => $new,
            'fields' => $fields,
            'inTabs' => array_unique(array_column($fields, 'inTab')),
        ]);
    }

    /**
     * Update the specified News in storage.
     */
    public function update($id, UpdateNewsRequest $request)
    {
        $new = $this->newsRepository->find($id);

        if (empty($new)) {
            Flash::error('News not found');

            return redirect(route('news.index'));
        }

        $new = $this->newsRepository->update($request->all(), $id);

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
