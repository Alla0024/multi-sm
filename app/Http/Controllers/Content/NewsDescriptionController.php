<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateNewsDescriptionRequest;
use App\Http\Requests\UpdateNewsDescriptionRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\NewsDescriptionRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\NewsDescription;
use Flash;

class NewsDescriptionController extends AppBaseController
{
    /** @var NewsDescriptionRepository $newsDescriptionRepository*/
    private $newsDescriptionRepository;

    public function __construct(NewsDescriptionRepository $newsDescriptionRepo)
    {
        parent::__construct();

        $this->newsDescriptionRepository = $newsDescriptionRepo;
    }

    /**
     * Display a listing of the NewsDescription.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $newsDescriptions = $this->newsDescriptionRepository->paginate($perPage);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            NewsDescription::class
        ]);

        $this->template = 'pages.news_descriptions.index';

        return $this->renderOutput([
            'newsDescriptions' => $newsDescriptions,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new NewsDescription.
     */
    public function create()
    {
        $this->template = 'pages.news_descriptions.create';

        return $this->renderOutput();
    }

    /**
     * Store a newly created NewsDescription in storage.
     */
    public function store(CreateNewsDescriptionRequest $request)
    {
        $input = $request->all();

        $newsDescription = $this->newsDescriptionRepository->create($input);

        Flash::success('News Description saved successfully.');

        return redirect(route('newsDescriptions.index'));
    }

    /**
     * Display the specified NewsDescription.
     */
    public function show($id)
    {
        $newsDescription = $this->newsDescriptionRepository->find($id);

        if (empty($newsDescription)) {
            Flash::error('News Description not found');

            return redirect(route('newsDescriptions.index'));
        }

        $this->template = 'pages.news_descriptions.show';

        return $this->renderOutput(compact('newsDescription'));
}

    /**
     * Show the form for editing the specified NewsDescription.
     */
    public function edit($id)
    {
        $newsDescription = $this->newsDescriptionRepository->find($id);

        if (empty($newsDescription)) {
            Flash::error('News Description not found');

            return redirect(route('newsDescriptions.index'));
        }

        $this->template = 'pages.news_descriptions.edit';

        return $this->renderOutput(compact('newsDescription'));
    }

    /**
     * Update the specified NewsDescription in storage.
     */
    public function update($id, UpdateNewsDescriptionRequest $request)
    {
        $newsDescription = $this->newsDescriptionRepository->find($id);

        if (empty($newsDescription)) {
            Flash::error('News Description not found');

            return redirect(route('newsDescriptions.index'));
        }

        $newsDescription = $this->newsDescriptionRepository->update($request->all(), $id);

        Flash::success('News Description updated successfully.');

        return redirect(route('newsDescriptions.index'));
    }

    /**
     * Remove the specified NewsDescription from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $newsDescription = $this->newsDescriptionRepository->find($id);

        if (empty($newsDescription)) {
            Flash::error('News Description not found');

            return redirect(route('newsDescriptions.index'));
        }

        $this->newsDescriptionRepository->delete($id);

        Flash::success('News Description deleted successfully.');

        return redirect(route('newsDescriptions.index'));
    }
}
