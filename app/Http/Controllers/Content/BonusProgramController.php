<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateBonusProgramRequest;
use App\Http\Requests\UpdateBonusProgramRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\BonusProgramDescription;
use App\Models\FirstPathQuery;
use App\Repositories\BonusProgramRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\BonusProgram;
use Flash;

class BonusProgramController extends AppBaseController
{
    /** @var BonusProgramRepository $bonusProgramRepository*/
    private $bonusProgramRepository;

    public function __construct(BonusProgramRepository $bonusProgramRepo)
    {
        parent::__construct();

        $this->bonusProgramRepository = $bonusProgramRepo;
    }

    /**
     * Display a listing of the BonusProgram.
     */
    public function index(Request $request)
    {
        $bonusPrograms = $this->bonusProgramRepository->filterRows($request->all());

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            BonusProgramDescription::class,
            BonusProgram::class
        ]);

        $this->template = 'pages.bonus_programs.index';

        return $this->renderOutput([
            'bonusPrograms' => $bonusPrograms,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new BonusProgram.
     */
    public function create()
    {
        $this->template = 'pages.bonus_programs.create';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            BonusProgramDescription::class,
            BonusProgram::class,
            FirstPathQuery::class
        ]);

        return $this->renderOutput([
            'fields' => $fields,
        ]);
    }

    /**
     * Store a newly created BonusProgram in storage.
     */
    public function store(CreateBonusProgramRequest $request)
    {
        $input = $request->all();

        $bonusProgram = $this->bonusProgramRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('bonusPrograms.index'));
    }

    /**
     * Display the specified BonusProgram.
     */
    public function show($id)
    {
        $bonusProgram = $this->bonusProgramRepository->findFull($id);

        if (empty($bonusProgram)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('bonusPrograms.index'));
        }

        $this->template = 'pages.bonus_programs.show';

        return $this->renderOutput(compact('bonusProgram'));
}

    /**
     * Show the form for editing the specified BonusProgram.
     */
    public function edit($id)
    {
        $bonusProgram = $this->bonusProgramRepository->findFull($id);

        if (empty($bonusProgram)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('bonusPrograms.index'));
        }

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            BonusProgramDescription::class,
            BonusProgram::class,
            FirstPathQuery::class
        ]);

        $this->template = 'pages.bonus_programs.edit';

        return $this->renderOutput(compact('bonusProgram', 'fields'));
    }

    /**
     * Update the specified BonusProgram in storage.
     */
    public function update($id, UpdateBonusProgramRequest $request)
    {
        $bonusProgram = $this->bonusProgramRepository->find($id);

        if (empty($bonusProgram)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('bonusPrograms.index'));
        }

        $bonusProgram = $this->bonusProgramRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        if ($request->ajax()) {
            return redirect(route('bonusPrograms.edit', $id));
        }

        return redirect(route('bonusPrograms.index'));
    }

    /**
     * Remove the specified BonusProgram from storage.
     *
     * @throws \Exception
     */
    public function destroy($ids)
    {
        $this->bonusProgramRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('bonusPrograms.index'));
    }

    public function copy(Request $request)
    {
        $ids = $request->input('bonus_program_ids');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->bonusProgramRepository->copy($ids);

            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('bonusPrograms.index');
        }

        Flash::error(__('common.flash_error'));

        return redirect()->route('bonusPrograms.index');
    }
}
