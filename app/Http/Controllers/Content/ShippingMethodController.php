<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateShippingMethodRequest;
use App\Http\Requests\UpdateShippingMethodRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\ShippingMethodDescription;
use App\Repositories\ShippingMethodRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\ShippingMethod;
use Flash;

class ShippingMethodController extends AppBaseController
{
    /** @var ShippingMethodRepository $shippingMethodRepository */
    private $shippingMethodRepository;

    public function __construct(ShippingMethodRepository $shippingMethodRepo)
    {
        parent::__construct();

        $this->shippingMethodRepository = $shippingMethodRepo;
    }

    /**
     * Display a listing of the ShippingMethod.
     */
    public function index(Request $request)
    {
        $shippingMethods = $this->shippingMethodRepository->filterRows($request->all());

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            ShippingMethodDescription::class,
            ShippingMethod::class
        ]);

        $this->template = 'pages.shipping_methods.index';

        return $this->renderOutput([
            'shippingMethods' => $shippingMethods,
            'fields' => $fields,
        ]);
    }

    /**
     * Show the form for creating a new ShippingMethod.
     */
    public function create()
    {
        $this->template = 'pages.shipping_methods.create';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            ShippingMethodDescription::class,
            ShippingMethod::class
        ]);

        return $this->renderOutput([
            'fields' => $fields,
        ]);
    }

    /**
     * Store a newly created ShippingMethod in storage.
     */
    public function store(CreateShippingMethodRequest $request)
    {
        $input = $request->all();

        $shippingMethod = $this->shippingMethodRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('shippingMethods.index'));
    }

    /**
     * Display the specified ShippingMethod.
     */
    public function show($id)
    {
        $shippingMethod = $this->shippingMethodRepository->findFull($id);

        if (empty($shippingMethod)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('shippingMethods.index'));
        }

        $this->template = 'pages.shipping_methods.show';

        return $this->renderOutput(compact('shippingMethod'));
    }

    /**
     * Show the form for editing the specified ShippingMethod.
     */
    public function edit($id)
    {
        $shippingMethod = $this->shippingMethodRepository->findFull($id);

        if (empty($shippingMethod)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('shippingMethods.index'));
        }
        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            ShippingMethodDescription::class,
            ShippingMethod::class
        ]);

        $this->template = 'pages.shipping_methods.edit';

        return $this->renderOutput(compact('shippingMethod', 'fields'));
    }

    /**
     * Update the specified ShippingMethod in storage.
     */
    public function update($id, UpdateShippingMethodRequest $request)
    {
        $shippingMethod = $this->shippingMethodRepository->find($id);

        if (empty($shippingMethod)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('shippingMethods.index'));
        }

        $shippingMethod = $this->shippingMethodRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        if ($request->ajax()) {
            return redirect(route('shippingMethods.edit', $id));
        }

        return redirect(route('shippingMethods.index'));
    }

    /**
     * Remove the specified ShippingMethod from storage.
     *
     * @throws \Exception
     */
    public function destroy($ids)
    {
        $this->shippingMethodRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('shippingMethods.index'));
    }

    public function copy(Request $request)
    {
        $ids = $request->input('shipping_method_ids');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->shippingMethodRepository->copy($ids);

            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('shippingMethods.index');
        }

        Flash::error(__('common.flash_error'));

        return redirect()->route('shippingMethods.index');
    }
}
