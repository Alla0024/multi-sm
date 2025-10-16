<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateStockStatusRequest;
use App\Http\Requests\UpdateStockStatusRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\StockStatusRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\StockStatus;
use Flash;

class StockStatusController extends AppBaseController
{
    /** @var StockStatusRepository $stockStatusRepository*/
    private $stockStatusRepository;

    public function __construct(StockStatusRepository $stockStatusRepo)
    {
        parent::__construct();

        $this->stockStatusRepository = $stockStatusRepo;
    }

    /**
     * Display a listing of the StockStatus.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $stockStatuses = $this->stockStatusRepository->paginate($perPage);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            StockStatus::class
        ]);

        $this->template = 'pages.stock_statuses.index';

        return $this->renderOutput([
            'stockStatuses' => $stockStatuses,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new StockStatus.
     */
    public function create()
    {
        $this->template = 'pages.stock_statuses.create';

        return $this->renderOutput();
    }

    /**
     * Store a newly created StockStatus in storage.
     */
    public function store(CreateStockStatusRequest $request)
    {
        $input = $request->all();

        $stockStatus = $this->stockStatusRepository->create($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('stockStatuses.index'));
    }

    /**
     * Display the specified StockStatus.
     */
    public function show($id)
    {
        $stockStatus = $this->stockStatusRepository->find($id);

        if (empty($stockStatus)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('stockStatuses.index'));
        }

        $this->template = 'pages.stock_statuses.show';

        return $this->renderOutput(compact('stockStatus'));
}

    /**
     * Show the form for editing the specified StockStatus.
     */
    public function edit($id)
    {
        $stockStatus = $this->stockStatusRepository->find($id);

        if (empty($stockStatus)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('stockStatuses.index'));
        }

        $this->template = 'pages.stock_statuses.edit';

        return $this->renderOutput(compact('stockStatus'));
    }

    /**
     * Update the specified StockStatus in storage.
     */
    public function update($id, UpdateStockStatusRequest $request)
    {
        $stockStatus = $this->stockStatusRepository->find($id);

        if (empty($stockStatus)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('stockStatuses.index'));
        }

        $stockStatus = $this->stockStatusRepository->update($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        return redirect(route('stockStatuses.index'));
    }

    /**
     * Remove the specified StockStatus from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $stockStatus = $this->stockStatusRepository->find($id);

        if (empty($stockStatus)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('stockStatuses.index'));
        }

        $this->stockStatusRepository->delete($id);

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('stockStatuses.index'));
    }
}
