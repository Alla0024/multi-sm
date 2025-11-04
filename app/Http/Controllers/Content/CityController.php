<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\CityDescription;
use App\Repositories\CityRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\City;
use Flash;

class CityController extends AppBaseController
{
    /** @var CityRepository $cityRepository */
    private $cityRepository;

    public function __construct(CityRepository $cityRepo)
    {
        parent::__construct();

        $this->cityRepository = $cityRepo;
    }

    /**
     * Display a listing of the City.
     */
    public function index(Request $request)
    {
        $cities = $this->cityRepository->filterRows($request->all());

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            CityDescription::class,
            City::class
        ]);

        $this->template = 'pages.cities.index';

        return $this->renderOutput([
            'cities' => $cities,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new City.
     */
    public function create()
    {
        $this->template = 'pages.cities.create';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            CityDescription::class,
            City::class
        ]);

        return $this->renderOutput([
            'fields' => $fields,
        ]);
    }

    /**
     * Store a newly created City in storage.
     */
    public function store(CreateCityRequest $request)
    {
        $input = $request->all();

        $city = $this->cityRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('cities.index'));
    }

    /**
     * Display the specified City.
     */
    public function show($id)
    {
        $city = $this->cityRepository->findFull($id);

        if (empty($city)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('cities.index'));
        }

        $this->template = 'pages.cities.show';

        return $this->renderOutput(compact('city'));
    }

    /**
     * Show the form for editing the specified City.
     */
    public function edit($id)
    {
        $city = $this->cityRepository->findFull($id);

        if (empty($city)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('cities.index'));
        }

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            CityDescription::class,
            City::class
        ]);


        $this->template = 'pages.cities.edit';

        return $this->renderOutput(compact('city', 'fields'));
    }

    /**
     * Update the specified City in storage.
     */
    public function update($id, UpdateCityRequest $request)
    {
        $city = $this->cityRepository->find($id);

        if (empty($city)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('cities.index'));
        }

        $city = $this->cityRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        if ($request->ajax()) {
            return redirect(route('cities.edit', $id));
        }

        return redirect(route('cities.index'));
    }

    /**
     * Remove the specified City from storage.
     *
     * @throws \Exception
     */
    public function destroy($ids)
    {
        $this->cityRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('cities.index'));
    }
}
