<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateNewsToProductRequest;
use App\Http\Requests\UpdateNewsToProductRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\NewsToProductRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\NewsToProduct;
use Flash;

class NewsToProductController extends AppBaseController
{
    /** @var NewsToProductRepository $newsToProductRepository*/
    private $newsToProductRepository;

    public function __construct(NewsToProductRepository $newsToProductRepo)
    {
        parent::__construct();

        $this->newsToProductRepository = $newsToProductRepo;
    }

    /**
     * Display a listing of the NewsToProduct.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $newsToProducts = $this->newsToProductRepository->paginate($perPage);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            NewsToProduct::class
        ]);

        $this->template = 'pages.news_to_products.index';

        return $this->renderOutput([
            'newsToProducts' => $newsToProducts,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new NewsToProduct.
     */
    public function create()
    {
        $this->template = 'pages.news_to_products.create';

        return $this->renderOutput();
    }

    /**
     * Store a newly created NewsToProduct in storage.
     */
    public function store(CreateNewsToProductRequest $request)
    {
        $input = $request->all();

        $newsToProduct = $this->newsToProductRepository->create($input);

        Flash::success('News To Product saved successfully.');

        return redirect(route('newsToProducts.index'));
    }

    /**
     * Display the specified NewsToProduct.
     */
    public function show($id)
    {
        $newsToProduct = $this->newsToProductRepository->find($id);

        if (empty($newsToProduct)) {
            Flash::error('News To Product not found');

            return redirect(route('newsToProducts.index'));
        }

        $this->template = 'pages.news_to_products.show';

        return $this->renderOutput(compact('newsToProduct'));
}

    /**
     * Show the form for editing the specified NewsToProduct.
     */
    public function edit($id)
    {
        $newsToProduct = $this->newsToProductRepository->find($id);

        if (empty($newsToProduct)) {
            Flash::error('News To Product not found');

            return redirect(route('newsToProducts.index'));
        }

        $this->template = 'pages.news_to_products.edit';

        return $this->renderOutput(compact('newsToProduct'));
    }

    /**
     * Update the specified NewsToProduct in storage.
     */
    public function update($id, UpdateNewsToProductRequest $request)
    {
        $newsToProduct = $this->newsToProductRepository->find($id);

        if (empty($newsToProduct)) {
            Flash::error('News To Product not found');

            return redirect(route('newsToProducts.index'));
        }

        $newsToProduct = $this->newsToProductRepository->update($request->all(), $id);

        Flash::success('News To Product updated successfully.');

        return redirect(route('newsToProducts.index'));
    }

    /**
     * Remove the specified NewsToProduct from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $newsToProduct = $this->newsToProductRepository->find($id);

        if (empty($newsToProduct)) {
            Flash::error('News To Product not found');

            return redirect(route('newsToProducts.index'));
        }

        $this->newsToProductRepository->delete($id);

        Flash::success('News To Product deleted successfully.');

        return redirect(route('newsToProducts.index'));
    }
}
