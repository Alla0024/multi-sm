<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateOptionValueGroupRequest;
use App\Http\Requests\UpdateOptionValueGroupRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\LanguageRepository;
use App\Repositories\OptionValueGroupRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\OptionValueGroup;
use Flash;

class OptionValueGroupController extends AppBaseController
{
    /**
     * @var OptionValueGroupRepository $optionValueGroupRepository
     * */
    private OptionValueGroupRepository $optionValueGroupRepository;

    public function __construct(OptionValueGroupRepository $optionValueGroupRepo)
    {
        parent::__construct();

        $this->optionValueGroupRepository = $optionValueGroupRepo;
    }

    /**
     * Display a listing of the OptionValueGroup.
     */
    public function index(Request $request)
    {
        $optionValueGroups = $this->optionValueGroupRepository->paginate();

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            OptionValueGroup::class
        ]);

        $this->template = 'pages.option_value_groups.index';

        return $this->renderOutput([
            'optionValueGroups' => $optionValueGroups,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new OptionValueGroup.
     */
    public function create()
    {
        $this->template = 'pages.option_value_groups.create';

        return $this->renderOutput();
    }

    /**
     * Store a newly created OptionValueGroup in storage.
     */
    public function store(CreateOptionValueGroupRequest $request)
    {
        $input = $request->all();

        $optionValueGroup = $this->optionValueGroupRepository->create($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('optionValueGroups.index'));
    }

    /**
     * Display the specified OptionValueGroup.
     */
    public function show($id)
    {
        $optionValueGroup = $this->optionValueGroupRepository->find($id);

        if (empty($optionValueGroup)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('optionValueGroups.index'));
        }

        $this->template = 'pages.option_value_groups.show';

        return $this->renderOutput(compact('optionValueGroup'));
}

    /**
     * Show the form for editing the specified OptionValueGroup.
     */
    public function edit($id)
    {
        $optionValueGroup = $this->optionValueGroupRepository->find($id);

        if (empty($optionValueGroup)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('optionValueGroups.index'));
        }

        $this->template = 'pages.option_value_groups.edit';

        return $this->renderOutput(compact('optionValueGroup'));
    }

    /**
     * Update the specified OptionValueGroup in storage.
     */
    public function update($id, UpdateOptionValueGroupRequest $request)
    {
        $optionValueGroup = $this->optionValueGroupRepository->find($id);

        if (empty($optionValueGroup)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('optionValueGroups.index'));
        }

        $optionValueGroup = $this->optionValueGroupRepository->update($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        return redirect(route('optionValueGroups.index'));
    }

    /**
     * Remove the specified OptionValueGroup from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $optionValueGroup = $this->optionValueGroupRepository->find($id);

        if (empty($optionValueGroup)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('optionValueGroups.index'));
        }

        $this->optionValueGroupRepository->delete($id);

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('optionValueGroups.index'));
    }
}
