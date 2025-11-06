<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateIndividualEntrepreneurRequest;
use App\Http\Requests\UpdateIndividualEntrepreneurRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Bank;
use App\Models\PaymentMethod;
use App\Repositories\IndividualEntrepreneurRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\IndividualEntrepreneur;
use Flash;

class IndividualEntrepreneurController extends AppBaseController
{
    /** @var IndividualEntrepreneurRepository $individualEntrepreneurRepository*/
    private $individualEntrepreneurRepository;

    public function __construct(IndividualEntrepreneurRepository $individualEntrepreneurRepo)
    {
        parent::__construct();

        $this->individualEntrepreneurRepository = $individualEntrepreneurRepo;
    }

    /**
     * Display a listing of the IndividualEntrepreneur.
     */
    public function index(Request $request)
    {
        $individualEntrepreneurs = $this->individualEntrepreneurRepository->filterRows($request->all());

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            IndividualEntrepreneur::class
        ]);
        $this->template = 'pages.individual_entrepreneurs.index';

        return $this->renderOutput([
            'individualEntrepreneurs' => $individualEntrepreneurs,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new IndividualEntrepreneur.
     */
    public function create()
    {
        $this->template = 'pages.individual_entrepreneurs.create';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            IndividualEntrepreneur::class
        ]);

        return $this->renderOutput([
            'fields' => $fields,
        ]);
    }

    /**
     * Store a newly created IndividualEntrepreneur in storage.
     */
    public function store(CreateIndividualEntrepreneurRequest $request)
    {
        $input = $request->all();

        $individualEntrepreneur = $this->individualEntrepreneurRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('individualEntrepreneurs.index'));
    }

    /**
     * Display the specified IndividualEntrepreneur.
     */
    public function show($id)
    {
        $individualEntrepreneur = $this->individualEntrepreneurRepository->findFull($id);

        if (empty($individualEntrepreneur)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('individualEntrepreneurs.index'));
        }

        $this->template = 'pages.individual_entrepreneurs.show';

        return $this->renderOutput(compact('individualEntrepreneur'));
}

    /**
     * Show the form for editing the specified IndividualEntrepreneur.
     */
    public function edit($id)
    {
        $individualEntrepreneur = $this->individualEntrepreneurRepository->findFull($id);
        $bank = Bank::with('description')->get();
        $paymentMethods = PaymentMethod::with('description')->get()->keyBy('id')->toArray();
        $paymentMethodsIds = array_column($individualEntrepreneur['paymentMethods']->toArray(), 'payment_id');

        if (empty($individualEntrepreneur)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('individualEntrepreneurs.index'));
        }
        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            IndividualEntrepreneur::class
        ]);

        $this->template = 'pages.individual_entrepreneurs.edit';

        return $this->renderOutput(compact('individualEntrepreneur', 'paymentMethods', 'bank', 'paymentMethodsIds', 'fields'));
    }

    /**
     * Update the specified IndividualEntrepreneur in storage.
     */
    public function update($id, UpdateIndividualEntrepreneurRequest $request)
    {
        $individualEntrepreneur = $this->individualEntrepreneurRepository->find($id);

        if (empty($individualEntrepreneur)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('individualEntrepreneurs.index'));
        }

        $individualEntrepreneur = $this->individualEntrepreneurRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        if ($request->ajax()) {
            return redirect(route('individualEntrepreneurs.edit', $id));
        }

        return redirect(route('individualEntrepreneurs.index'));
    }

    /**
     * Remove the specified IndividualEntrepreneur from storage.
     *
     * @throws \Exception
     */
    public function destroy($ids)
    {
        $this->individualEntrepreneurRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('individualEntrepreneurs.index'));
    }
    public function copy(Request $request)
    {
        $ids = $request->input('individual_entrepreneur_ids');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->individualEntrepreneurRepository->copy($ids);

            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('individualEntrepreneurs.index');
        }

        Flash::error(__('common.flash_error'));

        return redirect()->route('individualEntrepreneurs.index');
    }
}
