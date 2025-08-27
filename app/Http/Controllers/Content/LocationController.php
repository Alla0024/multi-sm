<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\LocationRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\Location;
use Flash;

class LocationController extends AppBaseController
{
    /** @var LocationRepository $locationRepository*/
    private $locationRepository;

    public function __construct(LocationRepository $locationRepo)
    {
        parent::__construct();

        $this->locationRepository = $locationRepo;
    }

    /**
     * Display a listing of the Location.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $locations = $this->locationRepository->paginate($perPage);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Location::class
        ]);

        $this->template = 'pages.locations.index';

        return $this->renderOutput([
            'locations' => $locations,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new Location.
     */
    public function create()
    {
        $this->template = 'pages.locations.create';

        return $this->renderOutput();
    }

    /**
     * Store a newly created Location in storage.
     */
    public function store(CreateLocationRequest $request)
    {
        $input = $request->all();

        $location = $this->locationRepository->create($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('locations.index'));
    }

    /**
     * Display the specified Location.
     */
    public function show($id)
    {
        $location = $this->locationRepository->find($id);

        if (empty($location)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('locations.index'));
        }

        $this->template = 'pages.locations.show';

        return $this->renderOutput(compact('location'));
}

    /**
     * Show the form for editing the specified Location.
     */
    public function edit($id)
    {
        $location = $this->locationRepository->find($id);

        if (empty($location)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('locations.index'));
        }

        $this->template = 'pages.locations.edit';

        return $this->renderOutput(compact('location'));
    }

    /**
     * Update the specified Location in storage.
     */
    public function update($id, UpdateLocationRequest $request)
    {
        $location = $this->locationRepository->find($id);

        if (empty($location)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('locations.index'));
        }

        $location = $this->locationRepository->update($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        return redirect(route('locations.index'));
    }

    /**
     * Remove the specified Location from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $location = $this->locationRepository->find($id);

        if (empty($location)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('locations.index'));
        }

        $this->locationRepository->delete($id);

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('locations.index'));
    }
}
