<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreatePaymentMethodRequest;
use App\Http\Requests\UpdatePaymentMethodRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\PaymentMethodDescription;
use App\Repositories\PaymentMethodRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Flash;

class PaymentMethodController extends AppBaseController
{
    /** @var PaymentMethodRepository $paymentMethodRepository*/
    private $paymentMethodRepository;

    public function __construct(PaymentMethodRepository $paymentMethodRepo)
    {
        parent::__construct();

        $this->paymentMethodRepository = $paymentMethodRepo;
    }

    /**
     * Display a listing of the PaymentMethod.
     */
    public function index(Request $request)
    {
        $paymentMethods = $this->paymentMethodRepository->filterRows($request->all());

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            PaymentMethodDescription::class,
            PaymentMethod::class
        ]);

        $this->template = 'pages.payment_methods.index';

        return $this->renderOutput([
            'paymentMethods' => $paymentMethods,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new PaymentMethod.
     */
    public function create()
    {
        $this->template = 'pages.payment_methods.create';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            PaymentMethodDescription::class,
            PaymentMethod::class
        ]);

        return $this->renderOutput([
            'fields' => $fields,
        ]);
    }

    /**
     * Store a newly created PaymentMethod in storage.
     */
    public function store(CreatePaymentMethodRequest $request)
    {
        $input = $request->all();

        $paymentMethod = $this->paymentMethodRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('paymentMethods.index'));
    }

    /**
     * Display the specified PaymentMethod.
     */
    public function show($id)
    {
        $paymentMethod = $this->paymentMethodRepository->findFull($id);

        if (empty($paymentMethod)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('paymentMethods.index'));
        }

        $this->template = 'pages.payment_methods.show';

        return $this->renderOutput(compact('paymentMethod'));
}

    /**
     * Show the form for editing the specified PaymentMethod.
     */
    public function edit($id)
    {
        $paymentMethod = $this->paymentMethodRepository->findFull($id);

        if (empty($paymentMethod)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('paymentMethods.index'));
        }

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            PaymentMethodDescription::class,
            PaymentMethod::class
        ]);

        $this->template = 'pages.payment_methods.edit';

        return $this->renderOutput(compact('paymentMethod', 'fields'));
    }

    /**
     * Update the specified PaymentMethod in storage.
     */
    public function update($id, UpdatePaymentMethodRequest $request)
    {
        $paymentMethod = $this->paymentMethodRepository->find($id);

        if (empty($paymentMethod)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('paymentMethods.index'));
        }

        $paymentMethod = $this->paymentMethodRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        if ($request->ajax()) {
            return redirect(route('paymentMethods.edit', $id));
        }

        return redirect(route('paymentMethods.index'));
    }

    /**
     * Remove the specified PaymentMethod from storage.
     *
     * @throws \Exception
     */
    public function destroy($ids)
    {
        $this->paymentMethodRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('paymentMethods.index'));
    }

    public function copy(Request $request)
    {
        $ids = $request->input('payment_method_ids');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->paymentMethodRepository->copy($ids);

            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('paymentMethods.index');
        }

        Flash::error(__('common.flash_error'));

        return redirect()->route('paymentMethods.index');
    }
}
