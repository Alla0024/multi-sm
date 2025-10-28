<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\FirstPathQuery;
use App\Models\SaleDescription;
use App\Repositories\SaleRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\Sale;
use Flash;

class SaleController extends AppBaseController
{
    /** @var SaleRepository $saleRepository */
    private $saleRepository;

    public function __construct(SaleRepository $saleRepo)
    {
        parent::__construct();

        $this->saleRepository = $saleRepo;
    }

    /**
     * Display a listing of the Sale.
     */
    public function index(Request $request)
    {
        $sales = $this->saleRepository->filterRows($request->all());

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            SaleDescription::class,
            Sale::class
        ]);

        $this->template = 'pages.sales.index';

        return $this->renderOutput([
            'sales' => $sales,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new Sale.
     */
    public function create()
    {
        $this->template = 'pages.sales.create';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            SaleDescription::class,
            FirstPathQuery::class,
        ]);

        return $this->renderOutput([
            'fields' => $fields,
        ]);
    }

    /**
     * Store a newly created Sale in storage.
     */
    public function store(CreateSaleRequest $request)
    {
        $input = $request->all();

        $sale = $this->saleRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('sales.index'));
    }

    /**
     * Display the specified Sale.
     */
    public function show($id)
    {
        $sale = $this->saleRepository->findFull($id);

        if (empty($sale)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('sales.index'));
        }

        $this->template = 'pages.sales.show';

        return $this->renderOutput(compact('sale'));
    }

    /**
     * Show the form for editing the specified Sale.
     */
    public function edit($id)
    {
        $sale = $this->saleRepository->findFull($id);

        if (empty($sale)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('sales.index'));
        }

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            SaleDescription::class,
            FirstPathQuery::class,
        ]);

        $this->template = 'pages.sales.edit';

        return $this->renderOutput(compact('sale', 'fields'));
    }

    /**
     * Update the specified Sale in storage.
     */
    public function update($id, UpdateSaleRequest $request)
    {
        $sale = $this->saleRepository->find($id);

        if (empty($sale)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('sales.index'));
        }

        $sale = $this->saleRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        if ($request->ajax()) {
            return redirect(route('sales.edit', $id));
        }

        return redirect(route('sales.index'));
    }

    /**
     * Remove the specified Sale from storage.
     *
     * @throws \Exception
     */
    public function destroy($ids)
    {
        $this->saleRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('sales.index'));
    }

    public function copy(Request $request)
    {
        $ids = $request->input('sale_ids');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->saleRepository->copy($ids);

            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('sales.index');
        }

        Flash::error(__('common.flash_error'));

        return redirect()->route('sales.index');
    }
}
