<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\ProductDescription;
use App\Repositories\ProductRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\Product;
use Flash;

class ProductController extends AppBaseController
{
    /** @var ProductRepository $productRepository*/
    private $productRepository;

    public function __construct(ProductRepository $productRepo)
    {
        parent::__construct();

        $this->productRepository = $productRepo;
    }

    /**
     * Display a listing of the Product.
     */
    public function index(Request $request)
    {
        $products = $this->productRepository->filterRows($request->all());

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            ProductDescription::class,
            Product::class
        ]);

        $this->template = 'pages.products.index';

        return $this->renderOutput([
            'products' => $products,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new Product.
     */
    public function create()
    {
        $this->template = 'pages.products.create';

        return $this->renderOutput();
    }

    /**
     * Store a newly created Product in storage.
     */
    public function store(CreateProductRequest $request)
    {
        $input = $request->all();

        $product = $this->productRepository->create($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('products.index'));
    }

    /**
     * Display the specified Product.
     */
    public function show($id)
    {
        $product = $this->productRepository->find($id);

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
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('products.index'));
        }

        $this->template = 'pages.products.edit';

        return $this->renderOutput(compact('product'));
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

        $product = $this->productRepository->update($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        return redirect(route('products.index'));
    }

    /**
     * Remove the specified Product from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('products.index'));
        }

        $this->productRepository->delete($id);

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('products.index'));
    }
}
