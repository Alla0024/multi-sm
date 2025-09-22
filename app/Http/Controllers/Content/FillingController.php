<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateFillingRequest;
use App\Http\Requests\UpdateFillingRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\FillingDescription;
use App\Repositories\FillingRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\Filling;
use Flash;

class FillingController extends AppBaseController
{
    /** @var FillingRepository $fillingRepository*/
    private $fillingRepository;

    public function __construct(FillingRepository $fillingRepo)
    {
        parent::__construct();

        $this->fillingRepository = $fillingRepo;
    }

    /**
     * Display a listing of the Filling.
     */
    public function index(Request $request)
    {
        $fillings = $this->fillingRepository->filterRows($request);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            FillingDescription::class,
            Filling::class
        ]);

        $this->template = 'pages.fillings.index';

        return $this->renderOutput([
            'fillings' => $fillings,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new Filling.
     */
    public function create()
    {
        $this->template = 'pages.fillings.create';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            FillingDescription::class,
            Filling::class
        ]);

        return $this->renderOutput([
            'fields' => $fields,
        ]);
    }

    /**
     * Store a newly created Filling in storage.
     */
    public function store(CreateFillingRequest $request)
    {
        $input = $request->all();

        $filling = $this->fillingRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('fillings.index'));
    }

    /**
     * Display the specified Filling.
     */
    public function show($id)
    {
        $filling = $this->fillingRepository->findFull($id);

        if (empty($filling)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('fillings.index'));
        }

        $this->template = 'pages.fillings.show';

        return $this->renderOutput(compact('filling'));
}

    /**
     * Show the form for editing the specified Filling.
     */
    public function edit($id)
    {
        $filling = $this->fillingRepository->findFull($id);

        if (empty($filling)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('fillings.index'));
        }

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            FillingDescription::class,
            Filling::class
        ]);

        $this->template = 'pages.fillings.edit';

        return $this->renderOutput(compact('filling', 'fields'));
    }

    /**
     * Update the specified Filling in storage.
     */
    public function update($id, UpdateFillingRequest $request)
    {
        $filling = $this->fillingRepository->find($id);

        if (empty($filling)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('fillings.index'));
        }

        $filling = $this->fillingRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        if ($request->ajax()) {
            return redirect(route('fillings.edit', $id));
        }

        return redirect(route('fillings.index'));
    }

    /**
     * Remove the specified Filling from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {

        $this->fillingRepository->multiDelete(explode(',', $id));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('fillings.index'));
    }

    public function copy(Request $request)
    {
        $ids = $request->input('filling_ids');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->fillingRepository->copy($ids);

            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('fillings.index');
        }

        Flash::error(__('common.flash_error'));

        return redirect()->route('fillings.index');
    }
}
