<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use App\Repositories\StoreRepository;
use Flash;
use Illuminate\Http\Request;

class StoreController extends AppBaseController
{
    /** @var StoreRepository $storeRepository */
    private $storeRepository;

    public function __construct(StoreRepository $storeRepo)
    {
        $this->storeRepository = $storeRepo;

        parent::__construct();
    }

    /**
     * Display a listing of the Store.
     */
    public function index(Request $request)
    {
        $stores = $this->storeRepository->paginate(10);

        return view('pages.stores.index')
            ->with('stores', $stores);
    }

    /**
     * Show the form for creating a new Store.
     */
    public function create()
    {
        return view('pages.stores.create');
    }

    /**
     * Store a newly created Store in storage.
     */
    public function store(CreateStoreRequest $request)
    {
        $input = $request->all();

        $store = $this->storeRepository->create($input);

        Flash::success('Store saved successfully.');

        return redirect(route('pages.stores.index'));
    }

    /**
     * Display the specified Store.
     */
    public function show($id)
    {
        $store = $this->storeRepository->find($id);

        if (empty($store)) {
            Flash::error('Store not found');

            return redirect(route('pages.stores.index'));
        }

        return view('pages.stores.show')->with('store', $store);
    }

    /**
     * Show the form for editing the specified Store.
     */
    public function edit($id)
    {
        $store = $this->storeRepository->find($id);

        if (empty($store)) {
            Flash::error('Store not found');

            return redirect(route('pages.stores.index'));
        }

        return view('pages.stores.edit')->with('store', $store);
    }

    /**
     * Update the specified Store in storage.
     */
    public function update($id, UpdateStoreRequest $request)
    {
        $store = $this->storeRepository->find($id);

        if (empty($store)) {
            Flash::error('Store not found');

            return redirect(route('pages.stores.index'));
        }

        $store = $this->storeRepository->update($request->all(), $id);

        Flash::success('Store updated successfully.');

        return redirect(route('pages.stores.index'));
    }

    /**
     * Remove the specified Store from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $store = $this->storeRepository->find($id);

        if (empty($store)) {
            Flash::error('Store not found');

            return redirect(route('pages.stores.index'));
        }

        $this->storeRepository->delete($id);

        Flash::success('Store deleted successfully.');

        return redirect(route('pages.stores.index'));
    }
}
