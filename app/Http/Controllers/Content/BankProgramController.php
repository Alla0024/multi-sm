<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateBankProgramRequest;
use App\Http\Requests\UpdateBankProgramRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\BankProgramDescription;
use App\Repositories\BankProgramRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\BankProgram;
use Flash;

class BankProgramController extends AppBaseController
{
    /** @var BankProgramRepository $bankProgramRepository*/
    private $bankProgramRepository;

    public function __construct(BankProgramRepository $bankProgramRepo)
    {
        parent::__construct();

        $this->bankProgramRepository = $bankProgramRepo;
    }

    /**
     * Display a listing of the BankProgram.
     */
    public function index(Request $request)
    {
        $bankPrograms = $this->bankProgramRepository->filterRows($request->all());

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            BankProgramDescription::class,
            BankProgram::class
        ]);

        $this->template = 'pages.bank_programs.index';

        return $this->renderOutput([
            'bankPrograms' => $bankPrograms,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new BankProgram.
     */
    public function create()
    {
        $this->template = 'pages.bank_programs.create';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            BankProgramDescription::class,
            BankProgram::class
        ]);

        return $this->renderOutput([
            'fields' => $fields,
        ]);
    }

    /**
     * Store a newly created BankProgram in storage.
     */
    public function store(CreateBankProgramRequest $request)
    {
        $input = $request->all();

        $bankProgram = $this->bankProgramRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('bankPrograms.index'));
    }

    /**
     * Display the specified BankProgram.
     */
    public function show($id)
    {
        $bankProgram = $this->bankProgramRepository->findFull($id);

        if (empty($bankProgram)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('bankPrograms.index'));
        }

        $this->template = 'pages.bank_programs.show';

        return $this->renderOutput(compact('bankProgram'));
}

    /**
     * Show the form for editing the specified BankProgram.
     */
    public function edit($id)
    {
        $bankProgram = $this->bankProgramRepository->findFull($id);

        if (empty($bankProgram)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('bankPrograms.index'));
        }

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            BankProgramDescription::class,
            BankProgram::class
        ]);

        $this->template = 'pages.bank_programs.edit';

        return $this->renderOutput(compact('bankProgram', 'fields'));
    }

    /**
     * Update the specified BankProgram in storage.
     */
    public function update($id, UpdateBankProgramRequest $request)
    {
        $bankProgram = $this->bankProgramRepository->find($id);

        if (empty($bankProgram)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('bankPrograms.index'));
        }

        $bankProgram = $this->bankProgramRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        if ($request->ajax()) {
            return redirect(route('bankPrograms.edit', $id));
        }

        return redirect(route('bankPrograms.index'));
    }

    /**
     * Remove the specified BankProgram from storage.
     *
     * @throws \Exception
     */
    public function destroy($ids)
    {
        $this->bankProgramRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('bankPrograms.index'));
    }

    public function copy(Request $request)
    {
        $ids = $request->input('bank_program_ids');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->bankProgramRepository->copy($ids);

            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('bankPrograms.index');
        }

        Flash::error(__('common.flash_error'));

        return redirect()->route('bankPrograms.index');
    }
}
