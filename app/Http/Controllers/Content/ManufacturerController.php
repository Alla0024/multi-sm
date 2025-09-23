<?php

namespace App\Http\Controllers\Content;

use App\Helpers\ModelSchemaHelper;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\ManufacturerRequest;
use App\Models\FirstPathQuery;
use App\Models\ManufacturerDescription;
use App\Repositories\ManufacturerRepository;
use Illuminate\Http\Request;
use App\Models\Manufacturer;
use Flash;

class ManufacturerController extends AppBaseController
{
    /** @var ManufacturerRepository $manufacturerRepository */
    private ManufacturerRepository $manufacturerRepository;

    public function __construct(ManufacturerRepository $manufacturerRepo)
    {
        $this->manufacturerRepository = $manufacturerRepo;

        parent::__construct();
    }

    /**
     * Display a listing of the Manufacturer.
     */
    public function index(Request $request)
    {
        $manufacturers = $this->manufacturerRepository->filterRows($request->all());

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            ManufacturerDescription::class,
            Manufacturer::class,
        ]);

        $this->template = 'pages.manufacturers.index';

        return $this->renderOutput([
            'manufacturers' => $manufacturers,
            'fields' => $fields,
        ]);
    }

    /**
     * Show the form for creating a new Manufacturer.
     */
    public function create()
    {
        $this->template = 'pages.manufacturers.create';
        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Manufacturer::class,
            ManufacturerDescription::class,
            FirstPathQuery::class
        ]);
        return $this->renderOutput([
            'fields' => $fields,
        ]);
    }

    /**
     * Store a newly created Manufacturer in storage.
     */
    public function store(ManufacturerRequest $request)
    {
        $manufacturer = $this->manufacturerRepository->save($request->all());

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('manufacturers.index'));
    }

    /**
     * Display the specified Manufacturer.
     */
    public function show($id)
    {
        $manufacturer = $this->manufacturerRepository->findFull($id);

        if (empty($manufacturer)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('manufacturers.index'));
        }

        $this->template = 'pages.manufacturers.show';

        return $this->renderOutput(compact('manufacturer'));
    }

    /**
     * Show the form for editing the specified Manufacturer.
     */
    public function edit($id)
    {
        $manufacturer = $this->manufacturerRepository->findFull($id);

        if (empty($manufacturer)) {
            Flash::error(__('common.flash_not_found'));
            return redirect(route('manufacturers.index'));
        }

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Manufacturer::class,
            ManufacturerDescription::class,
            FirstPathQuery::class
        ]);

        $this->template = 'pages.manufacturers.edit';

        return $this->renderOutput(compact('manufacturer', 'fields'));
    }

    /**
     * Update the specified Manufacturer in storage.
     */
    public function update($id, ManufacturerRequest $request)
    {
        $manufacturer = $this->manufacturerRepository->find($id);

        if (empty($manufacturer)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('manufacturers.index'));
        }

        $manufacturer = $this->manufacturerRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        if ($request->ajax()) {
            return redirect(route('manufacturers.edit', $id));
        }
        return redirect(route('manufacturers.index'));
    }

    /**
     * Remove the specified Manufacturer from storage.
     */
    public function destroy($ids)
    {
        $this->manufacturerRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('manufacturers.index'));
    }

    public function copy(Request $request)
    {
        $ids = $request->input('manufacturer_ids');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->manufacturerRepository->copy($ids);

            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('manufacturers.index');
        }

        Flash::error(__('common.flash_error'));

        return redirect()->route('manufacturers.index');
    }
}
