<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateBankRequest;
use App\Http\Requests\UpdateBankRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\BankDescription;
use App\Repositories\BankRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\Bank;
use Flash;

class BankController extends AppBaseController
{
    /** @var BankRepository $bankRepository */
    private $bankRepository;

    public function __construct(BankRepository $bankRepo)
    {
        parent::__construct();

        $this->bankRepository = $bankRepo;
    }

    /**
     * Display a listing of the Bank.
     */
    public function index(Request $request)
    {
        $banks = $this->bankRepository->filterRows($request->all());

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            BankDescription::class,
            Bank::class
        ]);

        $this->template = 'pages.banks.index';

        return $this->renderOutput([
            'banks' => $banks,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new Bank.
     */
    public function create()
    {
        $this->template = 'pages.banks.create';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            BankDescription::class,
            Bank::class
        ]);

        return $this->renderOutput([
            'fields' => $fields,
        ]);
    }

    /**
     * Store a newly created Bank in storage.
     */
    public function store(CreateBankRequest $request)
    {
        $input = $request->all();

        $bank = $this->bankRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('banks.index'));
    }

    /**
     * Display the specified Bank.
     */
    public function show($id)
    {
        $bank = $this->bankRepository->findFull($id);

        if (empty($bank)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('banks.index'));
        }

        $this->template = 'pages.banks.show';

        return $this->renderOutput(compact('bank'));
    }

    /**
     * Show the form for editing the specified Bank.
     */
    public function edit($id)
    {
        $bank = $this->bankRepository->findFull($id);

        if (empty($bank)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('banks.index'));
        }

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            BankDescription::class,
            Bank::class
        ]);

        $this->template = 'pages.banks.edit';

        return $this->renderOutput(compact('bank', 'fields'));
    }

    /**
     * Update the specified Bank in storage.
     */
    public function update($id, UpdateBankRequest $request)
    {
        $bank = $this->bankRepository->find($id);

        if (empty($bank)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('banks.index'));
        }

        $bank = $this->bankRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        if ($request->ajax()) {
            return redirect(route('banks.edit', $id));
        }

        return redirect(route('banks.index'));
    }

    /**
     * Remove the specified Bank from storage.
     *
     * @throws \Exception
     */
    public function destroy($ids)
    {
        $this->bankRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('banks.index'));
    }

    public function copy(Request $request)
    {
        $ids = $request->input('bank_ids');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->bankRepository->copy($ids);

            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('banks.index');
        }

        Flash::error(__('common.flash_error'));

        return redirect()->route('banks.index');
    }
}
