<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\UpdateInformationRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\FirstPathQuery;
use App\Models\InformationDescription;
use App\Repositories\InformationRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\Information;
use Flash;

class InformationController extends AppBaseController
{
    /**
     * @var InformationRepository $informationRepository
     * @var int $defaultLanguageId ;
     * */
    private InformationRepository $informationRepository;

    public function __construct(InformationRepository $informationRepo)
    {
        parent::__construct();

        $this->informationRepository = $informationRepo;
    }

    /**
     * Display a listing of the Information.
     */
    public function index(Request $request)
    {
        $information = $this->informationRepository->filterRows($request);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Information::class,
            InformationDescription::class,
        ]);

        $this->template = 'pages.information.index';

        return $this->renderOutput([
            'information' => $information,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating the Information.
     */
    public function create()
    {
        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Information::class,
            InformationDescription::class,
            FirstPathQuery::class
        ]);

        $this->template = 'pages.information.create';

        return $this->renderOutput([
            'fields' => $fields,
        ]);
    }

    /**
     * Store a newly created Information in storage.
     */
    public function store(UpdateInformationRequest $request)
    {
        $information = $this->informationRepository->save($request->all());

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('information.index'));
    }

    /**
     * Display the specified Information.
     */
    public function show($id)
    {
        $information = $this->informationRepository->findFull($id);

        if (empty($information)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('information.index'));
        }

        $this->template = 'pages.information.show';

        return $this->renderOutput(compact('information'));
    }

    /**
     * Show the form for editing the specified Information.
     */
    public function edit($id)
    {
        $information = $this->informationRepository->findFull($id);

        if (empty($information)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('information.index'));
        }

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Information::class,
            InformationDescription::class,
            FirstPathQuery::class
        ]);
        $this->template = 'pages.information.edit';

        return $this->renderOutput([
            'information' => $information,
            'fields' => $fields,
            'inTabs' => array_unique(array_column($fields, 'inTab')),
        ]);
    }

    /**
     * Update the specified Information in storage.
     */
    public function update($id, UpdateInformationRequest $request)
    {
        $information = $this->informationRepository->find($id);

        if (empty($information)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('information.index'));
        }

        $information = $this->informationRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        return redirect(route('information.index'));
    }

    /**
     * Remove the specified Information from storage.
     */
    public function destroy($ids)
    {
        $this->informationRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('information.index'));
    }

    public function copy(Request $request)
    {
        $ids = $request->input('information_id');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->informationRepository->copy($ids);

            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('information.index');
        }

        Flash::error(__('common.flash_error'));

        return redirect()->route('information.index');
    }
}
