<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateSaleGroupRequest;
use App\Http\Requests\UpdateSaleGroupRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\SaleGroupDescription;
use App\Repositories\SaleGroupRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\SaleGroup;
use Flash;

class SaleGroupController extends AppBaseController
{
    /** @var SaleGroupRepository $saleGroupRepository*/
    private $saleGroupRepository;

    public function __construct(SaleGroupRepository $saleGroupRepo)
    {
        parent::__construct();

        $this->saleGroupRepository = $saleGroupRepo;
    }

    /**
     * Display a listing of the SaleGroup.
     */
    public function index(Request $request)
    {
        $saleGroups = $this->saleGroupRepository->filterRows($request->all());

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            SaleGroupDescription::class,
            SaleGroup::class
        ]);

        $this->template = 'pages.sale_groups.index';

        return $this->renderOutput([
            'saleGroups' => $saleGroups,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new SaleGroup.
     */
    public function create()
    {
        $this->template = 'pages.sale_groups.create';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            SaleGroupDescription::class,
            SaleGroup::class
        ]);

        return $this->renderOutput([
            'fields' => $fields,
        ]);
    }

    /**
     * Store a newly created SaleGroup in storage.
     */
    public function store(CreateSaleGroupRequest $request)
    {
        $input = $request->all();

        $saleGroup = $this->saleGroupRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('saleGroups.index'));
    }

    /**
     * Display the specified SaleGroup.
     */
    public function show($id)
    {
        $saleGroup = $this->saleGroupRepository->findFull($id);

        if (empty($saleGroup)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('saleGroups.index'));
        }

        $this->template = 'pages.sale_groups.show';

        return $this->renderOutput(compact('saleGroup'));
}

    /**
     * Show the form for editing the specified SaleGroup.
     */
    public function edit($id)
    {
        $saleGroup = $this->saleGroupRepository->findFull($id);

        if (empty($saleGroup)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('saleGroups.index'));
        }

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            SaleGroupDescription::class,
            SaleGroup::class
        ]);

        $this->template = 'pages.sale_groups.edit';

        return $this->renderOutput(compact('saleGroup', 'fields'));
    }

    /**
     * Update the specified SaleGroup in storage.
     */
    public function update($id, UpdateSaleGroupRequest $request)
    {
        $saleGroup = $this->saleGroupRepository->find($id);

        if (empty($saleGroup)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('saleGroups.index'));
        }

        $saleGroup = $this->saleGroupRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        if ($request->ajax()) {
            return redirect(route('saleGroups.edit', $id));
        }

        return redirect(route('saleGroups.index'));
    }

    /**
     * Remove the specified SaleGroup from storage.
     *
     * @throws \Exception
     */
    public function destroy($ids)
    {
        $this->saleGroupRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('saleGroups.index'));
    }
}
