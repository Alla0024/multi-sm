<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateProductReviewRequest;
use App\Http\Requests\UpdateProductReviewRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Product;
use App\Repositories\ProductReviewRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use Flash;

class ProductReviewController extends AppBaseController
{
    /** @var ProductReviewRepository $productReviewRepository */
    private $productReviewRepository;

    public function __construct(ProductReviewRepository $productReviewRepo)
    {
        parent::__construct();

        $this->productReviewRepository = $productReviewRepo;
    }

    /**
     * Display a listing of the ProductReview.
     */
    public function index(Request $request)
    {
        $productReviews = $this->productReviewRepository->filterRows($request->all());

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            ProductReview::class
        ]);

        $this->template = 'pages.product_reviews.index';

        return $this->renderOutput([
            'productReviews' => $productReviews,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new ProductReview.
     */
    public function create()
    {
        $this->template = 'pages.product_reviews.create';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            ProductReview::class
        ]);

        return $this->renderOutput([
            'fields' => $fields
        ]);
    }

    /**
     * Store a newly created ProductReview in storage.
     */
    public function store(CreateProductReviewRequest $request)
    {
        $input = $request->all();

        $productReview = $this->productReviewRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('productReviews.index'));
    }

    /**
     * Display the specified ProductReview.
     */
    public function show($id)
    {
        $productReview = $this->productReviewRepository->findFull($id);

        if (empty($productReview)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('productReviews.index'));
        }

        $this->template = 'pages.product_reviews.show';

        return $this->renderOutput(compact('productReview'));
    }

    /**
     * Show the form for editing the specified ProductReview.
     */
    public function edit($id)
    {
        $productReview = $this->productReviewRepository->findFull($id);
        $product = Product::with('description')
            ->whereStatus(1)
            ->where('id', $productReview['product_id'])
            ->first();

        if (empty($productReview)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('productReviews.index'));
        }

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            ProductReview::class
        ]);

        $this->template = 'pages.product_reviews.edit';

        return $this->renderOutput(compact('productReview', 'product', 'fields'));
    }

    /**
     * Update the specified ProductReview in storage.
     */
    public function update($id, UpdateProductReviewRequest $request)
    {
        $productReview = $this->productReviewRepository->find($id);

        if (empty($productReview)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('productReviews.index'));
        }

        $productReview = $this->productReviewRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        if ($request->ajax()) {
            return redirect(route('productReviews.edit', $id));
        }

        return redirect(route('productReviews.index'));
    }

    /**
     * Remove the specified ProductReview from storage.
     *
     * @throws \Exception
     */
    public function destroy($ids)
    {
        $this->productReviewRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('productReviews.index'));
    }

    public function copy(Request $request)
    {
        $ids = $request->input('review_ids');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->productReviewRepository->copy($ids);

            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('productReviews.index');
        }

        Flash::error(__('common.flash_error'));

        return redirect()->route('productReviews.index');
    }
}
