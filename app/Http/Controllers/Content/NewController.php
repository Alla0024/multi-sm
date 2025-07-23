<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateNewRequest;
use App\Http\Requests\UpdateNewRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\NewRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\New;
use Flash;

class NewController extends AppBaseController
{
    /** @var NewRepository $newRepository*/
    private $newRepository;

    public function __construct(NewRepository $newRepo)
    {
        parent::__construct();

        $this->newRepository = $newRepo;
    }

    /**
     * Display a listing of the New.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $news = $this->newRepository->paginate($perPage);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            New::class
        ]);

        $this->template = 'pages.news.index';

        return $this->renderOutput([
            'news' => $news,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new New.
     */
    public function create()
    {
        $this->template = 'pages.news.create';

        return $this->renderOutput();
    }

    /**
     * Store a newly created New in storage.
     */
    public function store(CreateNewRequest $request)
    {
        $input = $request->all();

        $new = $this->newRepository->create($input);

        Flash::success('New saved successfully.');

        return redirect(route('news.index'));
    }

    /**
     * Display the specified New.
     */
    public function show($id)
    {
        $new = $this->newRepository->find($id);

        if (empty($new)) {
            Flash::error('New not found');

            return redirect(route('news.index'));
        }

        $this->template = 'pages.news.show';

        return $this->renderOutput(compact('new'));
}

    /**
     * Show the form for editing the specified New.
     */
    public function edit($id)
    {
        $new = $this->newRepository->find($id);

        if (empty($new)) {
            Flash::error('New not found');

            return redirect(route('news.index'));
        }

        $this->template = 'pages.news.edit';

        return $this->renderOutput(compact('new'));
    }

    /**
     * Update the specified New in storage.
     */
    public function update($id, UpdateNewRequest $request)
    {
        $new = $this->newRepository->find($id);

        if (empty($new)) {
            Flash::error('New not found');

            return redirect(route('news.index'));
        }

        $new = $this->newRepository->update($request->all(), $id);

        Flash::success('New updated successfully.');

        return redirect(route('news.index'));
    }

    /**
     * Remove the specified New from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $new = $this->newRepository->find($id);

        if (empty($new)) {
            Flash::error('New not found');

            return redirect(route('news.index'));
        }

        $this->newRepository->delete($id);

        Flash::success('New deleted successfully.');

        return redirect(route('news.index'));
    }
}
