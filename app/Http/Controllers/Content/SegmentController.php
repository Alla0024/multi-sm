<?php

namespace App\Http\Controllers\Content;

use App\Helpers\CacheForever;
use App\Http\Requests\CreateSegmentRequest;
use App\Http\Requests\UpdateSegmentRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\SegmentDescription;
use App\Models\StockStatus;
use App\Repositories\SegmentRepository;
use App\Repositories\ProductRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\Segment;
use Flash;

class SegmentController extends AppBaseController
{
    /** @var SegmentRepository $segmentRepository */
    private $segmentRepository;

    /** @var ProductRepository $productRepository */
    private $productRepository;

    public function __construct(SegmentRepository $segmentRepo, ProductRepository $productRepo)
    {
        parent::__construct();
        $this->productRepository = $productRepo;
        $this->segmentRepository = $segmentRepo;
    }

    /**
     * Display a listing of the Segment.
     */
    public function index(Request $request)
    {
        $segments = $this->segmentRepository->filterRows($request->all());

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            SegmentDescription::class,
            Segment::class,
        ]);

        $this->template = 'pages.segments.index';

        return $this->renderOutput([
            'segments' => $segments,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new Segment.
     */
    public function create()
    {
        $this->template = 'pages.segments.create';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Segment::class,
            SegmentDescription::class,
        ]);

        return $this->renderOutput([
            $fields,
        ]);
    }

    /**
     * Store a newly created Segment in storage.
     */
    public function store(CreateSegmentRequest $request)
    {
        $input = $request->all();

        $segment = $this->segmentRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('segments.index'));
    }

    /**
     * Display the specified Segment.
     */
    public function show($id)
    {
        $segment = $this->segmentRepository->findFull((int) $id);

        if (empty($segment)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('segments.index'));
        }

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            SegmentDescription::class,
            Segment::class,
        ]);

        $this->template = 'pages.segments.show';

        return $this->renderOutput(compact('segment', 'fields'));
    }

    /**
     * Show the form for editing the specified Segment.
     */
    public function edit(Request $request, $id)
    {
        $segment = $this->segmentRepository->findFull((int) $id);

        if (empty($segment)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('segments.index'));
        }

        $products = $this->productRepository->filterRows($request->all());
        $stockStatuses = CacheForever::getStockStatuses();
        $stockStatusesDescription = StockStatus::with('description')->get()->keyBy('id')->toArray();
        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            SegmentDescription::class,
            Segment::class,
        ]);

        $this->template = 'pages.segments.edit';

        return $this->renderOutput(compact('segment', 'stockStatuses', 'stockStatusesDescription', 'products','fields'));
    }

    /**
     * Update the specified Segment in storage.
     */
    public function update($id, UpdateSegmentRequest $request)
    {
        $segment = $this->segmentRepository->find($id);

        if (empty($segment)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('segments.index'));
        }

        $segment = $this->segmentRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        if ($request->ajax()) {
            return redirect(route('segments.edit', $id));
        }

        return redirect(route('segments.index'));
    }

    /**
     * Remove the specified Segment from storage.
     *
     * @throws \Exception
     */
    public function destroy($ids)
    {
        $this->segmentRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('segments.index'));
    }

    public function copy(Request $request)
    {
        $ids = $request->input('segment_ids');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->segmentRepository->copy($ids);
            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('segments.index');
        }
        Flash::error(__('common.flash_error'));

        return redirect()->route('segments.index');
    }

    public function addProductToSegment(Request $request)
    {
        $segmentId = (int) $request->get('segment_id');
        $productIds = (array) $request->get('product_ids', []);

        $this->segmentRepository->addProductsToSegment($segmentId, $productIds);

        return response()->json([
            'success' => true,
            'message' => $this->vars['word']['successful_insert'],
        ]);
    }

    public function removeProductFromSegment(Request $request)
    {
        $segmentId = (int) $request->get('segment_id');
        $productIds = (array) $request->get('product_ids', []);

        $this->segmentRepository->removeProductsFromSegment($segmentId, $productIds);

        return response()->json([
            'success' => true,
            'message' => $this->vars['word']['successful_delete'],
        ]);
    }

    public function addFilteredProductsToSegment(Request $request, int $segmentId)
    {
        $this->segmentRepository->addFilteredProductsToSegment($request->all(), $segmentId);

        return response()->json([
            'success' => true,
            'message' => $this->vars['word']['successful_insert'],
        ]);
    }

    public function removeFilteredProductsFromSegment(Request $request, int $segmentId)
    {
        $this->segmentRepository->removeFilteredProductsFromSegment($request->all(), $segmentId);

        return response()->json([
            'success' => true,
            'message' => $this->vars['word']['successful_delete'],
        ]);
    }
}
