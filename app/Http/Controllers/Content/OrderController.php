<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\OrderRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\Order;
use Flash;

class OrderController extends AppBaseController
{
    /** @var OrderRepository $orderRepository*/
    private $orderRepository;

    public function __construct(OrderRepository $orderRepo)
    {
        parent::__construct();

        $this->orderRepository = $orderRepo;
    }

    /**
     * Display a listing of the Order.
     */
    public function index(Request $request)
    {
        $orders = $this->orderRepository->filterRows($request->all());
        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Order::class
        ]);

        $this->template = 'pages.orders.index';

        return $this->renderOutput([
            'orders' => $orders,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new Order.
     */
    public function create()
    {
        $this->template = 'pages.orders.create';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Order::class
        ]);

        return $this->renderOutput([
            'fields' => $fields,
        ]);
    }

    /**
     * Store a newly created Order in storage.
     */
    public function store(CreateOrderRequest $request)
    {
        $input = $request->all();

        $order = $this->orderRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('orders.index'));
    }

    /**
     * Display the specified Order.
     */
    public function show($id)
    {
        $order = $this->orderRepository->findFull($id);

        if (empty($order)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('orders.index'));
        }

        $this->template = 'pages.orders.show';

        return $this->renderOutput(compact('order'));
}

    /**
     * Show the form for editing the specified Order.
     */
    public function edit($id)
    {
        $order = $this->orderRepository->findFull($id);

        if (empty($order)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('orders.index'));
        }

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Order::class
        ]);

        $this->template = 'pages.orders.edit';

        return $this->renderOutput(compact('order', 'fields'));
    }

    /**
     * Update the specified Order in storage.
     */
    public function update($id, UpdateOrderRequest $request)
    {
        $order = $this->orderRepository->find($id);

        if (empty($order)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('orders.index'));
        }

        $order = $this->orderRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        if ($request->ajax()) {
            return redirect(route('orders.edit', $id));
        }

        return redirect(route('orders.index'));
    }

    /**
     * Remove the specified Order from storage.
     *
     * @throws \Exception
     */
    public function destroy($ids)
    {
        $this->orderRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('orders.index'));
    }
}
