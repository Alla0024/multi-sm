<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateFilterRequest;
use App\Http\Requests\UpdateFilterRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\FilterGroup;
use App\Models\FilterGroupDescription;
use App\Repositories\FilterGroupRepository;
use App\Repositories\FilterRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use Flash;

class FilterController extends AppBaseController
{
    /** @var FilterRepository $filterRepository*/
    private $filterRepository;

    /** @var FilterGroupRepository $filterGroupRepository*/
    private $filterGroupRepository;

    public function __construct(
        FilterRepository $filterRepo,
        FilterGroupRepository $filterGroupRepo
    )
    {
        parent::__construct();

        $this->filterRepository = $filterRepo;
        $this->filterGroupRepository = $filterGroupRepo;
    }

    /**
     * Display a listing of the Filter.
     */
    public function index(Request $request)
    {
        $filters = $this->filterGroupRepository->filterRows($request->all());

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            FilterGroupDescription::class,
            FilterGroup::class
        ]);

        $this->template = 'pages.filters.index';

        return $this->renderOutput([
            'filters' => $filters,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new Filter.
     */
    public function create()
    {
        $this->template = 'pages.filters.create';

        return $this->renderOutput();
    }

    /**
     * Store a newly created Filter in storage.
     */
    public function store(CreateFilterRequest $request)
    {
        $input = $request->all();

        $filter = $this->filterRepository->create($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('filters.index'));
    }

    /**
     * Display the specified Filter.
     */
    public function show($id)
    {
        $filter = $this->filterRepository->find($id);

        if (empty($filter)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('filters.index'));
        }

        $this->template = 'pages.filters.show';

        return $this->renderOutput(compact('filter'));
}

    /**
     * Show the form for editing the specified Filter.
     */
    public function edit($id)
    {
        $filter = $this->filterRepository->find($id);

        if (empty($filter)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('filters.index'));
        }

        $this->template = 'pages.filters.edit';

        return $this->renderOutput(compact('filter'));
    }

    /**
     * Update the specified Filter in storage.
     */
    public function update($id, UpdateFilterRequest $request)
    {
        $filter = $this->filterRepository->find($id);

        if (empty($filter)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('filters.index'));
        }

        $filter = $this->filterRepository->update($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        return redirect(route('filters.index'));
    }

    /**
     * Remove the specified Filter from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $filter = $this->filterRepository->find($id);

        if (empty($filter)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('filters.index'));
        }

        $this->filterRepository->delete($id);

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('filters.index'));
    }
}
