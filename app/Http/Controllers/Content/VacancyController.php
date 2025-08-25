<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateVacancyRequest;
use App\Http\Requests\UpdateVacancyRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\VacancyDescription;
use App\Repositories\LanguageRepository;
use App\Repositories\VacancyRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\Vacancy;
use Flash;

class VacancyController extends AppBaseController
{
    /**
     * @var VacancyRepository $vacancyRepository
     * @var LanguageRepository $languageRepository
     * @var int $defaultLanguageId;
     * */
    private VacancyRepository $vacancyRepository;
    private LanguageRepository $languageRepository;
    private int $defaultLanguageId;

    public function __construct(
        VacancyRepository $vacancyRepo,
        LanguageRepository $languageRepo,
    )
    {
        parent::__construct();

        $this->vacancyRepository = $vacancyRepo;
        $this->languageRepository = $languageRepo;
        $this->defaultLanguageId = config('settings.locale.default_language_id');
    }

    /**
     * Display a listing of the Vacancy.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $vacancies = $this->vacancyRepository->filterIndexPage($perPage, $this->defaultLanguageId, $request->all());
        $languages = $this->languageRepository->getAvailableLanguages();

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            VacancyDescription::class,
            Vacancy::class
        ]);

        $this->template = 'pages.vacancies.index';

        return $this->renderOutput([
            'vacancies' => $vacancies,
            'languages' => $languages,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new Vacancy.
     */
    public function create()
    {
        $this->template = 'pages.vacancies.create';

        return $this->renderOutput();
    }

    /**
     * Store a newly created Vacancy in storage.
     */
    public function store(CreateVacancyRequest $request)
    {
        $input = $request->all();

        $vacancy = $this->vacancyRepository->create($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('vacancies.index'));
    }

    /**
     * Display the specified Vacancy.
     */
    public function show($id)
    {
        $vacancy = $this->vacancyRepository->find($id);

        if (empty($vacancy)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('vacancies.index'));
        }

        $this->template = 'pages.vacancies.show';

        return $this->renderOutput(compact('vacancy'));
}

    /**
     * Show the form for editing the specified Vacancy.
     */
    public function edit($id)
    {
        $vacancy = $this->vacancyRepository->getDetails($id);
        $languages = $this->languageRepository->getAvailableLanguages();

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            VacancyDescription::class,
            Vacancy::class
        ]);

        if (empty($vacancy)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('vacancies.index'));
        }

        $this->template = 'pages.vacancies.edit';

        return $this->renderOutput(compact('vacancy', 'fields', 'languages'));
    }

    /**
     * Update the specified Vacancy in storage.
     */
    public function update($id, UpdateVacancyRequest $request)
    {
        $vacancy = $this->vacancyRepository->find($id);

        if (empty($vacancy)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('vacancies.index'));
        }

        $vacancy = $this->vacancyRepository->update($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        return redirect(route('vacancies.index'));
    }

    /**
     * Remove the specified Vacancy from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $vacancy = $this->vacancyRepository->find($id);

        if (empty($vacancy)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('vacancies.index'));
        }

        $this->vacancyRepository->delete($id);

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('vacancies.index'));
    }
}
