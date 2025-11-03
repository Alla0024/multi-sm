<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateMunicipalityRequest;
use App\Http\Requests\UpdateMunicipalityRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\MunicipalityDescription;
use App\Repositories\MunicipalityRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\Municipality;
use Flash;

class MunicipalityController extends AppBaseController
{
    /** @var MunicipalityRepository $municipalityRepository */
    private $municipalityRepository;

    public function __construct(MunicipalityRepository $municipalityRepo)
    {
        parent::__construct();

        $this->municipalityRepository = $municipalityRepo;
    }

    /**
     * Display a listing of the Municipality.
     */
    public function index(Request $request)
    {
        $municipalities = $this->municipalityRepository->filterRows($request->all());

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            MunicipalityDescription::class,
            Municipality::class
        ]);

        $this->template = 'pages.municipalities.index';

        return $this->renderOutput([
            'municipalities' => $municipalities,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new Municipality.
     */
    public function create()
    {
        $this->template = 'pages.municipalities.create';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            MunicipalityDescription::class,
            Municipality::class
        ]);

        return $this->renderOutput([
            'fields' => $fields,
        ]);
    }

    /**
     * Store a newly created Municipality in storage.
     */
    public function store(CreateMunicipalityRequest $request)
    {
        $input = $request->all();

        $municipality = $this->municipalityRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('municipalities.index'));
    }

    /**
     * Display the specified Municipality.
     */
    public function show($id)
    {
        $municipality = $this->municipalityRepository->findFull($id);

        if (empty($municipality)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('municipalities.index'));
        }

        $this->template = 'pages.municipalities.show';

        return $this->renderOutput(compact('municipality'));
    }

    /**
     * Show the form for editing the specified Municipality.
     */
    public function edit($id)
    {
        $municipality = $this->municipalityRepository->findFull($id);

        if (empty($municipality)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('municipalities.index'));
        }

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            MunicipalityDescription::class,
            Municipality::class
        ]);

        $this->template = 'pages.municipalities.edit';

        return $this->renderOutput(compact('municipality', 'fields'));
    }

    /**
     * Update the specified Municipality in storage.
     */
    public function update($id, UpdateMunicipalityRequest $request)
    {
        $municipality = $this->municipalityRepository->find($id);

        if (empty($municipality)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('municipalities.index'));
        }

        $municipality = $this->municipalityRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        if ($request->ajax()) {
            return redirect(route('municipalities.edit', $id));
        }

        return redirect(route('municipalities.index'));
    }

    /**
     * Remove the specified Municipality from storage.
     *
     * @throws \Exception
     */
    public function destroy($ids)
    {
        $this->municipalityRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('municipalities.index'));
    }

    public function copy(Request $request)
    {
        $ids = $request->input('municipality_ids');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->municipalityRepository->copy($ids);

            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('municipalities.index');
        }

        Flash::error(__('common.flash_error'));

        return redirect()->route('municipalities.index');
    }
}
