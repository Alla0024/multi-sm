<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\FirstPathQuery;
use App\Models\ProductDescription;
use App\Models\StockStatus;
use App\Repositories\CurrencyRepository;
use App\Repositories\LocationRepository;
use App\Repositories\OptionRepository;
use App\Repositories\ProductRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\Product;
use Flash;

class ProductController extends AppBaseController
{
    /** @var ProductRepository $productRepository */
    private $productRepository;

    /** @var LocationRepository $locationRepository */
    private $locationRepository;

    /** @var OptionRepository $optionRepository */
    private $optionRepository;

    /** @var $currencyRepository */
    private $currencyRepository;

    public function __construct(
        ProductRepository  $productRepo,
        LocationRepository $locationRepo,
        OptionRepository   $optionRepo,
        CurrencyRepository $currencyRepo)
    {
        parent::__construct();

        $this->productRepository = $productRepo;
        $this->locationRepository = $locationRepo;
        $this->optionRepository = $optionRepo;
        $this->currencyRepository = $currencyRepo;
    }

    /**
     * Display a listing of the Product.
     */
    public function index(Request $request)
    {
        $products = $this->productRepository->filterRows($request->all());
        $stockStatuses = StockStatus::getStockStatuses();

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            ProductDescription::class,
            Product::class
        ]);

        $this->template = 'pages.products.index';

        return $this->renderOutput([
            'products' => $products,
            'stockStatuses' => $stockStatuses,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new Product.
     */
    public function create()
    {
        $this->template = 'pages.products.create';
        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Product::class,
            ProductDescription::class,
            FirstPathQuery::class
        ]);

        $options = $this->optionRepository->getCachedOptions();
        $locations = $this->locationRepository->getCachedLocations();
        $currencies = $this->currencyRepository->getCachedCurrencies();

        return $this->renderOutput([
            'fields' => $fields,
            'options' => $options,
            'locations' => $locations,
            'currencies' => $currencies,
        ]);
    }

    /**
     * Store a newly created Product in storage.
     */
    public function store(CreateProductRequest $request)
    {
        $input = $request->all();

        $product = $this->productRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('products.index'));
    }

    /**
     * Display the specified Product.
     */
    public function show($id)
    {
        $product = $this->productRepository->findFull($id);

        if (empty($product)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('products.index'));
        }

        $this->template = 'pages.products.show';

        return $this->renderOutput(compact('product'));
    }

    /**
     * Show the form for editing the specified Product.
     */
    public function edit($id)
    {
        $product = $this->productRepository->findFull($id);

        if (empty($product)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('products.index'));
        }

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Product::class,
            ProductDescription::class,
            FirstPathQuery::class
        ]);

        $options = $this->optionRepository->getCachedOptions();
        $locations = $this->locationRepository->getCachedLocations();
        $currencies = $this->currencyRepository->getCachedCurrencies();

        $this->template = 'pages.products.edit';

        return $this->renderOutput(compact('product', 'fields', 'options', 'locations', 'currencies'));
    }

    /**
     * Update the specified Product in storage.
     */
    public function update($id, UpdateProductRequest $request)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('products.index'));
        }

        $product = $this->productRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        if ($request->ajax()) {
            return redirect(route('products.edit', $id));
        }

        return redirect(route('products.index'));
    }

    /**
     * Remove the specified Product from storage.
     *
     * @throws \Exception
     */
    public function destroy($ids)
    {
        $this->productRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('products.index'));
    }

    public function copy(Request $request)
    {
        $ids = $request->input('product_ids');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->productRepository->copy($ids);

            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('products.index');
        }

        Flash::error(__('common.flash_error'));

        return redirect()->route('products.index');
    }

    public function changeSortOrder(Request $request)
    {
        if ($request->ajax() && $request->filled(['product_id', 'sort_order'])) {
            $updated = $this->productRepository->update(
                ['sort_order' => $request->sort_order],
                $request->product_id
            );

            return response()->json(['success' => (bool)$updated]);
        }

        return response()->json(['success' => false]);
    }


}
