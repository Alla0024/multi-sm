<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateCurrencyRequest;
use App\Http\Requests\UpdateCurrencyRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\CurrencyRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\Currency;
use Flash;

class CurrencyController extends AppBaseController
{
    /** @var CurrencyRepository $currencyRepository*/
    private $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepo)
    {
        parent::__construct();

        $this->currencyRepository = $currencyRepo;
    }

    /**
     * Display a listing of the Currency.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $currencies = $this->currencyRepository->paginate($perPage);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Currency::class
        ]);

        $this->template = 'pages.currencies.index';

        return $this->renderOutput([
            'currencies' => $currencies,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new Currency.
     */
    public function create()
    {
        $this->template = 'pages.currencies.create';

        return $this->renderOutput();
    }

    /**
     * Store a newly created Currency in storage.
     */
    public function store(CreateCurrencyRequest $request)
    {
        $input = $request->all();

        $currency = $this->currencyRepository->create($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('currencies.index'));
    }

    /**
     * Display the specified Currency.
     */
    public function show($id)
    {
        $currency = $this->currencyRepository->find($id);

        if (empty($currency)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('currencies.index'));
        }

        $this->template = 'pages.currencies.show';

        return $this->renderOutput(compact('currency'));
}

    /**
     * Show the form for editing the specified Currency.
     */
    public function edit($id)
    {
        $currency = $this->currencyRepository->find($id);

        if (empty($currency)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('currencies.index'));
        }

        $this->template = 'pages.currencies.edit';

        return $this->renderOutput(compact('currency'));
    }

    /**
     * Update the specified Currency in storage.
     */
    public function update($id, UpdateCurrencyRequest $request)
    {
        $currency = $this->currencyRepository->find($id);

        if (empty($currency)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('currencies.index'));
        }

        $currency = $this->currencyRepository->update($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        return redirect(route('currencies.index'));
    }

    /**
     * Remove the specified Currency from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $currency = $this->currencyRepository->find($id);

        if (empty($currency)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('currencies.index'));
        }

        $this->currencyRepository->delete($id);

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('currencies.index'));
    }
}
