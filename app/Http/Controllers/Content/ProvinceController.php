<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateProvinceRequest;
use App\Http\Requests\UpdateProvinceRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\ProvinceDescription;
use App\Repositories\ProvinceRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\Province;
use Flash;

class ProvinceController extends AppBaseController
{
    /** @var ProvinceRepository $provinceRepository */
    private $provinceRepository;

    public function __construct(ProvinceRepository $provinceRepo)
    {
        parent::__construct();

        $this->provinceRepository = $provinceRepo;
    }

    /**
     * Display a listing of the Province.
     */
    public function index(Request $request)
    {
        $provinces = $this->provinceRepository->filterRows($request->all());

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            ProvinceDescription::class,
            Province::class
        ]);

        $this->template = 'pages.provinces.index';

        return $this->renderOutput([
            'provinces' => $provinces,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new Province.
     */
    public function create()
    {
        $this->template = 'pages.provinces.create';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            ProvinceDescription::class,
            Province::class
        ]);

        return $this->renderOutput([
            'fields' => $fields,
        ]);
    }

    /**
     * Store a newly created Province in storage.
     */
    public function store(CreateProvinceRequest $request)
    {
        $input = $request->all();

        $province = $this->provinceRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('provinces.index'));
    }

    /**
     * Display the specified Province.
     */
    public function show($id)
    {
        $province = $this->provinceRepository->findFull($id);

        if (empty($province)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('provinces.index'));
        }

        $this->template = 'pages.provinces.show';

        return $this->renderOutput(compact('province'));
    }

    /**
     * Show the form for editing the specified Province.
     */
    public function edit($id)
    {
        $province = $this->provinceRepository->find($id);

        if (empty($province)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('provinces.index'));
        }

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            ProvinceDescription::class,
            Province::class
        ]);

        $this->template = 'pages.provinces.edit';

        return $this->renderOutput(compact('province', 'fields'));
    }

    /**
     * Update the specified Province in storage.
     */
    public function update($id, UpdateProvinceRequest $request)
    {
        $province = $this->provinceRepository->find($id);

        if (empty($province)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('provinces.index'));
        }

        $province = $this->provinceRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));


        if ($request->ajax()) {
            return redirect(route('provinces.edit', $id));
        }

        return redirect(route('provinces.index'));
    }

    /**
     * Remove the specified Province from storage.
     *
     * @throws \Exception
     */
    public function destroy($ids)
    {
        $this->provinceRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('provinces.index'));
    }

    public function copy(Request $request)
    {
        $ids = $request->input('province_ids');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->provinceRepository->copy($ids);

            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('provinces.index');
        }

        Flash::error(__('common.flash_error'));

        return redirect()->route('provinces.index');
    }
}
