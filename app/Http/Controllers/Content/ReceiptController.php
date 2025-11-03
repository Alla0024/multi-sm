<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateReceiptRequest;
use App\Http\Requests\UpdateReceiptRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ReceiptRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\Receipt;
use Flash;

class ReceiptController extends AppBaseController
{
    /** @var ReceiptRepository $receiptRepository*/
    private $receiptRepository;

    public function __construct(ReceiptRepository $receiptRepo)
    {
        parent::__construct();

        $this->receiptRepository = $receiptRepo;
    }

    /**
     * Display a listing of the Receipt.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $receipts = $this->receiptRepository->paginate($perPage);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Receipt::class
        ]);

        $this->template = 'pages.receipts.index';

        return $this->renderOutput([
            'receipts' => $receipts,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new Receipt.
     */
    public function create()
    {
        $this->template = 'pages.receipts.create';

        return $this->renderOutput();
    }

    /**
     * Store a newly created Receipt in storage.
     */
    public function store(CreateReceiptRequest $request)
    {
        $input = $request->all();

        $receipt = $this->receiptRepository->create($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('receipts.index'));
    }

    /**
     * Display the specified Receipt.
     */
    public function show($id)
    {
        $receipt = $this->receiptRepository->find($id);

        if (empty($receipt)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('receipts.index'));
        }

        $this->template = 'pages.receipts.show';

        return $this->renderOutput(compact('receipt'));
}

    /**
     * Show the form for editing the specified Receipt.
     */
    public function edit($id)
    {
        $receipt = $this->receiptRepository->find($id);

        if (empty($receipt)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('receipts.index'));
        }

        $this->template = 'pages.receipts.edit';

        return $this->renderOutput(compact('receipt'));
    }

    /**
     * Update the specified Receipt in storage.
     */
    public function update($id, UpdateReceiptRequest $request)
    {
        $receipt = $this->receiptRepository->find($id);

        if (empty($receipt)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('receipts.index'));
        }

        $receipt = $this->receiptRepository->update($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        return redirect(route('receipts.index'));
    }

    /**
     * Remove the specified Receipt from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $receipt = $this->receiptRepository->find($id);

        if (empty($receipt)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('receipts.index'));
        }

        $this->receiptRepository->delete($id);

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('receipts.index'));
    }
}
