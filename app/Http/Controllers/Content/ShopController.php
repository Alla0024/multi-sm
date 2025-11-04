<?php

namespace App\Http\Controllers\Content;

use App\Helpers\CacheForever;
use App\Http\Requests\CreateShopRequest;
use App\Http\Requests\UpdateShopRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\ShopDescription;
use App\Repositories\ShopRepository;
use App\Helpers\ModelSchemaHelper;
use App\Repositories\LocationRepository;
use Illuminate\Http\Request;
use App\Models\Shop;
use Flash;

class ShopController extends AppBaseController
{
    /** @var ShopRepository $shopRepository*/
    private $shopRepository;

    private LocationRepository $locationRepository;

    public function __construct(
        ShopRepository $shopRepo,
        LocationRepository $locationRepo,
    )
    {
        parent::__construct();

        $this->shopRepository = $shopRepo;
        $this->locationRepository = $locationRepo;
    }

    /**
     * Display a listing of the Shop.
     */
    public function index(Request $request)
    {
        $shops = $this->shopRepository->filterRows($request->all());
        $locations = $this->locationRepository->getDropdownItems(5, $request->all());
        $locations = collect($locations)->pluck('text', 'id')->toArray();
        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            ShopDescription::class,
            Shop::class
        ]);

        $this->template = 'pages.shops.index';

        return $this->renderOutput([
            'shops' => $shops,
            'locations' => $locations,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new Shop.
     */
    public function create(Request $request)
    {
        $this->template = 'pages.shops.create';
        $locations = $this->locationRepository->getDropdownItems(5, $request->all());
        $locations = collect($locations)->pluck('text', 'id')->toArray();
        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            ShopDescription::class,
            Shop::class
        ]);

        return $this->renderOutput(['fields' => $fields, 'locations' => $locations]);
    }

    /**
     * Store a newly created Shop in storage.
     */
    public function store(CreateShopRequest $request)
    {
        $input = $request->all();

        $shop = $this->shopRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('shops.index'));
    }

    /**
     * Display the specified Shop.
     */
    public function show($id)
    {
        $shop = $this->shopRepository->findFull($id);

        if (empty($shop)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('shops.index'));
        }

        $this->template = 'pages.shops.show';

        return $this->renderOutput(compact('shop'));
}

    /**
     * Show the form for editing the specified Shop.
     */
    public function edit($id, Request $request)
    {
        $shop = $this->shopRepository->findFull($id);
        $locations = $this->locationRepository->getDropdownItems(5, $request->all());
        $locations = collect($locations)->pluck('text', 'id')->toArray();

        $postcodes = CacheForever::getPostcodes();
        if (empty($shop)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('shops.index'));
        }

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            ShopDescription::class,
            Shop::class
        ]);

        $this->template = 'pages.shops.edit';

        return $this->renderOutput(compact('shop', 'fields', 'locations', 'postcodes'));
    }

    /**
     * Update the specified Shop in storage.
     */
    public function update($id, UpdateShopRequest $request)
    {
        $shop = $this->shopRepository->find($id);

        if (empty($shop)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('shops.index'));
        }

        $shop = $this->shopRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        if ($request->ajax()) {
            return redirect(route('shops.edit', $id));
        }

        return redirect(route('shops.index'));
    }

    /**
     * Remove the specified Shop from storage.
     *
     * @throws \Exception
     */
    public function destroy($ids)
    {
       $this->shopRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('shops.index'));
    }

    public function copy(Request $request)
    {
        $ids = $request->input('shop_ids');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->shopRepository->copy($ids);

            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('shops.index');
        }

        Flash::error(__('common.flash_error'));

        return redirect()->route('shops.index');
    }
}
