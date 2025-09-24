<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateNewsletterRequest;
use App\Http\Requests\UpdateNewsletterRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\NewsletterRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\Newsletter;
use Flash;

class NewsletterController extends AppBaseController
{
    /** @var NewsletterRepository $newsletterRepository*/
    private $newsletterRepository;

    public function __construct(NewsletterRepository $newsletterRepo)
    {
        parent::__construct();

        $this->newsletterRepository = $newsletterRepo;
    }

    /**
     * Display a listing of the Newsletter.
     */
    public function index(Request $request)
    {
        $newsletters = $this->newsletterRepository->filterRows($request->all());

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Newsletter::class
        ]);

        $this->template = 'pages.newsletters.index';

        return $this->renderOutput([
            'newsletters' => $newsletters,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new Newsletter.
     */
    public function create()
    {
        $this->template = 'pages.newsletters.create';
        $newsletter = [
            'authors' => config('settings.message_authors'),
            'types' => config('settings.message_types'),
        ];
        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Newsletter::class
        ]);
        return $this->renderOutput([
            'fields' => $fields,
            'newsletter' => $newsletter,
        ]);
    }

    /**
     * Store a newly created Newsletter in storage.
     */
    public function store(CreateNewsletterRequest $request)
    {
        $input = $request->all();

        $newsletter = $this->newsletterRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('newsletters.index'));
    }

    /**
     * Display the specified Newsletter.
     */
    public function show($id)
    {
        $newsletter = $this->newsletterRepository->findFull($id);

        if (empty($newsletter)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('newsletters.index'));
        }

        $this->template = 'pages.newsletters.show';

        return $this->renderOutput(compact('newsletter'));
}

    /**
     * Show the form for editing the specified Newsletter.
     */
    public function edit($id)
    {
        $newsletter = $this->newsletterRepository->findFull($id);

        if (empty($newsletter)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('newsletters.index'));
        }

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Newsletter::class
        ]);

        $this->template = 'pages.newsletters.edit';

        return $this->renderOutput(compact('newsletter', 'fields'));
    }

    /**
     * Update the specified Newsletter in storage.
     */
    public function update($id, UpdateNewsletterRequest $request)
    {
        $newsletter = $this->newsletterRepository->find($id);

        if (empty($newsletter)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('newsletters.index'));
        }

        $newsletter = $this->newsletterRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        if ($request->ajax()) {
            return redirect(route('newsletters.edit', $id));
        }

        return redirect(route('newsletters.index'));
    }

    public function copy(Request $request)
    {
        $ids = $request->input('newsletter_ids');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->newsletterRepository->copy($ids);

            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('newsletters.index');
        }

        Flash::error(__('common.flash_error'));

        return redirect()->route('newsletters.index');
    }
}
