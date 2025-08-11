<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateInformationRequest;
use App\Http\Requests\UpdateInformationRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\FirstPathQuery;
use App\Models\InformationDescription;
use App\Repositories\InformationRepository;
use App\Helpers\ModelSchemaHelper;
use App\Repositories\LanguageRepository;
use App\Repositories\StoreRepository;
use Illuminate\Http\Request;
use App\Models\Information;
use Flash;

class InformationController extends AppBaseController
{
    /**
     * @var InformationRepository $informationRepository
     * @var LanguageRepository $languageRepository
     * @var int $defaultLanguageId;
     * */
    private InformationRepository $informationRepository;
    private LanguageRepository $languageRepository;
    private int $defaultLanguageId;

    public function __construct(
        InformationRepository $informationRepo,
        LanguageRepository    $languageRepo,
        StoreRepository       $storeRepo,
    )
    {
        parent::__construct();

        $this->informationRepository = $informationRepo;
        $this->languageRepository = $languageRepo;
        $this->defaultLanguageId = config('settings.locale.default_language_id');
    }

    /**
     * Display a listing of the Information.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $information = $this->informationRepository->filterIndexPage($perPage, 5, request()->all());

        $information->each(function ($item) {
            if ($item->seoPath) {
                $baseUrl = config('app.client_url');
                $path = $item->seoPath->path;

                $item->setAttribute('client_url', rtrim($baseUrl, '/') . '/' . ltrim($path, '/'));
            }
        });

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            InformationDescription::class,
            Information::class,
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
        $languages = $this->languageRepository->all();

        $this->template = 'pages.information.create';
        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Information::class,
            InformationDescription::class,
            FirstPathQuery::class
        ]);

        return $this->renderOutput([
            'fields' => $fields,
            'languages' => $languages,
            'inTabs' => array_unique(array_column($fields, 'inTab')),
        ]);
    }

    /**
     * Store a newly created Information in storage.
     */
    public function store(CreateInformationRequest $request)
    {
        $input = $request->all();

        $information = $this->informationRepository->upsert($input);

        Flash::success('Information saved successfully.');

        return redirect(route('information.index'));
    }

    /**
     * Display the specified Information.
     */
    public function show($id)
    {
        $information = $this->informationRepository->find($id);
        $languages = $this->languageRepository->all();

        if (empty($information)) {
            Flash::error('Information not found');

            return redirect(route('information.index'));
        }

        $this->template = 'pages.information.show';

        return $this->renderOutput(compact('information', 'languages'));
}

    /**
     * Show the form for editing the specified Information.
     */
    public function edit($id)
    {
        $information = $this->informationRepository->find($id);
        $languages = $this->languageRepository->all();

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
            'languages' => $languages,
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
        $dto = $request->all();

        if (empty($information)) {
            Flash::error('Information not found');

            return redirect(route('information.index'));
        }

        $information = $this->informationRepository->upsert($dto, $id);

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
