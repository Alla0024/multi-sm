<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateInformationRequest;
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
    /** @var InformationRepository $informationRepository*/
    private $informationRepository;

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
        $perPage = $request->input('perPage', 10);

        $information = $this->informationRepository->paginate($perPage);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Information::class,
            InformationDescription::class
        ]);

        $this->template = 'pages.information.index';

        return $this->renderOutput([
            'information' => $information,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new Information.
     */
    public function create()
    {
        $this->template = 'pages.information.create';
        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Information::class,
            InformationDescription::class,
            FirstPathQuery::class
        ]);
        return $this->renderOutput([
            'fields' => $fields,
            'inTabs' => array_unique(array_column($fields, 'inTab')),
        ]);
    }

    /**
     * Store a newly created Information in storage.
     */
    public function store(CreateInformationRequest $request)
    {
        $input = $request->all();

        $information = $this->informationRepository->create($input);

        Flash::success('Information saved successfully.');

        return redirect(route('information.index'));
    }

    /**
     * Display the specified Information.
     */
    public function show($id)
    {
        $information = $this->informationRepository->find($id);

        if (empty($information)) {
            Flash::error('Information not found');

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
        $information = $this->informationRepository->find($id);

        if (empty($information)) {
            Flash::error('Information not found');

            return redirect(route('information.index'));
        }

        $seoUrl = FirstPathQuery::where('type_id', $id)->where('type', 'information')->value('path');
        $information->setAttribute('path', $seoUrl);

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
            Flash::error('Information not found');

            return redirect(route('information.index'));
        }

        $information = $this->informationRepository->update($request->all(), $id);

        Flash::success('Information updated successfully.');

        return redirect(route('information.index'));
    }

    /**
     * Remove the specified Information from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $information = $this->informationRepository->find($id);

        if (empty($information)) {
            Flash::error('Information not found');

            return redirect(route('information.index'));
        }

        $this->informationRepository->delete($id);

        Flash::success('Information deleted successfully.');

        return redirect(route('information.index'));
    }
}
