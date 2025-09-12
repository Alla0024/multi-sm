<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateAttributeGroupRequest;
use App\Http\Requests\UpdateAttributeGroupRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\AttributeGroupDescription;
use App\Repositories\AttributeGroupRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\AttributeGroup;
use Flash;

class AttributeGroupController extends AppBaseController
{
    /** @var AttributeGroupRepository $attributeGroupRepository*/
    private $attributeGroupRepository;

    public function __construct(AttributeGroupRepository $attributeGroupRepo)
    {
        parent::__construct();

        $this->attributeGroupRepository = $attributeGroupRepo;
    }

    /**
     * Display a listing of the AttributeGroup.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $attributeGroups = $this->attributeGroupRepository->filterRows($request);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            AttributeGroupDescription::class,
            AttributeGroup::class
        ], [
            'name',
            'sort_order'
        ]);

        $this->template = 'pages.attribute_groups.index';

        return $this->renderOutput([
            'attributeGroups' => $attributeGroups,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new AttributeGroup.
     */
    public function create()
    {
        $this->template = 'pages.attribute_groups.create';

        return $this->renderOutput();
    }

    /**
     * Store a newly created AttributeGroup in storage.
     */
    public function store(CreateAttributeGroupRequest $request)
    {
        $input = $request->all();

        $attributeGroup = $this->attributeGroupRepository->create($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('attributeGroups.index'));
    }

    /**
     * Display the specified AttributeGroup.
     */
    public function show($id)
    {
        $attributeGroup = $this->attributeGroupRepository->find($id);

        if (empty($attributeGroup)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('attributeGroups.index'));
        }

        $this->template = 'pages.attribute_groups.show';

        return $this->renderOutput(compact('attributeGroup'));
}

    /**
     * Show the form for editing the specified AttributeGroup.
     */
    public function edit($id)
    {
        $attributeGroup = $this->attributeGroupRepository->find($id);

        if (empty($attributeGroup)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('attributeGroups.index'));
        }

        $this->template = 'pages.attribute_groups.edit';

        return $this->renderOutput(compact('attributeGroup'));
    }

    /**
     * Update the specified AttributeGroup in storage.
     */
    public function update($id, UpdateAttributeGroupRequest $request)
    {
        $attributeGroup = $this->attributeGroupRepository->find($id);

        if (empty($attributeGroup)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('attributeGroups.index'));
        }

        $attributeGroup = $this->attributeGroupRepository->update($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        return redirect(route('attributeGroups.index'));
    }

    /**
     * Remove the specified AttributeGroup from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $attributeGroup = $this->attributeGroupRepository->find($id);

        if (empty($attributeGroup)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('attributeGroups.index'));
        }

        $this->attributeGroupRepository->delete($id);

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('attributeGroups.index'));
    }
}
