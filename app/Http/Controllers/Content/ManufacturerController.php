<?php

namespace App\Http\Controllers\Content;

use App\Helpers\ModelSchemaHelper;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateManufacturerRequest;
use App\Http\Requests\UpdateManufacturerRequest;
use App\Models\ManufacturerDescription;
use App\Repositories\LanguageRepository;
use App\Repositories\ManufacturerRepository;
use Flash;
use Illuminate\Http\Request;
use App\Models\Manufacturer;
class ManufacturerController extends AppBaseController
{
    /** @var ManufacturerRepository $manufacturerRepository*/
    private ManufacturerRepository $manufacturerRepository;

    /** @var LanguageRepository $languageRepository */
    private LanguageRepository $languageRepository;

    public function __construct(
        ManufacturerRepository $manufacturerRepo,
        LanguageRepository     $languageRepo)
    {
        $this->manufacturerRepository = $manufacturerRepo;
        $this->languageRepository = $languageRepo;

        parent::__construct();
    }

    /**
     * Display a listing of the Manufacturer.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $manufacturers = $this->manufacturerRepository->with(['descriptions'])->paginate($perPage);
        $languages = $this->languageRepository;

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Manufacturer::class,
            ManufacturerDescription::class,
        ]);

        $this->template = 'pages.manufacturers.index';

        return $this->renderOutput([
            'manufacturers' => $manufacturers,
            'languages' => $languages,
            'fields' => $fields,
            'inTabs' => array_unique(array_column($fields, 'inTab')),
        ]);
    }

    /**
     * Show the form for creating a new Manufacturer.
     */
    public function create()
    {
        $this->template = 'pages.manufacturers.create';

        return $this->renderOutput();
    }

    /**
     * Store a newly created Manufacturer in storage.
     */
    public function store(CreateManufacturerRequest $request)
    {
        $input = $request->all();

        $manufacturer = $this->manufacturerRepository->create($input);

        Flash::success(__('messages.saved', ['model' => __('models/manufacturers.singular')]));

        return redirect(route('manufacturers.index'));
    }

    /**
     * Display the specified Manufacturer.
     */
    public function show($id)
    {
        $manufacturer = $this->manufacturerRepository->find($id);

        if (empty($manufacturer)) {
            Flash::error(__('models/manufacturers.singular').' '.__('messages.not_found'));

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
        $manufacturer = $this->manufacturerRepository->find($id);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Manufacturer::class,
            ManufacturerDescription::class,
        ]);

        $inTabs = array_unique(array_column($fields, 'inTab'));

        if (empty($manufacturer)) {
            Flash::error(__('models/manufacturers.singular') . ' ' . __('messages.not_found'));

            return redirect(route('manufacturers.index'));
        }

        $this->template = 'pages.manufacturers.edit';


        return $this->renderOutput(compact('manufacturer', 'fields', 'inTabs'));
    }

    /**
     * Update the specified Manufacturer in storage.
     */
    public function update($id, UpdateManufacturerRequest $request)
    {
        $manufacturer = $this->manufacturerRepository->find($id);

        if (empty($manufacturer)) {
            Flash::error(__('models/manufacturers.singular').' '.__('messages.not_found'));

            return redirect(route('manufacturers.index'));
        }

        $manufacturer = $this->manufacturerRepository->update($request->all(), $id);

        Flash::success(__('messages.updated', ['model' => __('models/manufacturers.singular')]));

        return redirect(route('manufacturers.index'));
    }

    /**
     * Remove the specified Manufacturer from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $manufacturer = $this->manufacturerRepository->find($id);

        if (empty($manufacturer)) {
            Flash::error(__('models/manufacturers.singular').' '.__('messages.not_found'));

            return redirect(route('manufacturers.index'));
        }

        $this->manufacturerRepository->delete($id);

        Flash::success(__('messages.deleted', ['model' => __('models/manufacturers.singular')]));

        return redirect(route('manufacturers.index'));
    }
}
