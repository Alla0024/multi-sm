<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateAttributeIconRequest;
use App\Http\Requests\UpdateAttributeIconRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\AttributeIconRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\AttributeIcon;
use Flash;

class AttributeIconController extends AppBaseController
{
    /** @var AttributeIconRepository $attributeIconRepository*/
    private $attributeIconRepository;

    public function __construct(AttributeIconRepository $attributeIconRepo)
    {
        parent::__construct();

        $this->attributeIconRepository = $attributeIconRepo;
    }

    /**
     * Display a listing of the AttributeIcon.
     */
    public function index(Request $request)
    {
        $attributeIcons = $this->attributeIconRepository->filterRows($request);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            AttributeIcon::class
        ], [
            'title',
            'image'
        ]);

        $this->template = 'pages.attribute_icons.index';

        return $this->renderOutput([
            'attributeIcons' => $attributeIcons,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new AttributeIcon.
     */
    public function create()
    {
        $this->template = 'pages.attribute_icons.create';

        return $this->renderOutput();
    }

    /**
     * Store a newly created AttributeIcon in storage.
     */
    public function store(CreateAttributeIconRequest $request)
    {
        $input = $request->all();

        $attributeIcon = $this->attributeIconRepository->create($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('attributeIcons.index'));
    }

    /**
     * Display the specified AttributeIcon.
     */
    public function show($id)
    {
        $attributeIcon = $this->attributeIconRepository->find($id);

        if (empty($attributeIcon)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('attributeIcons.index'));
        }

        $this->template = 'pages.attribute_icons.show';

        return $this->renderOutput(compact('attributeIcon'));
}

    /**
     * Show the form for editing the specified AttributeIcon.
     */
    public function edit($id)
    {
        $attributeIcon = $this->attributeIconRepository->find($id);

        if (empty($attributeIcon)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('attributeIcons.index'));
        }

        $this->template = 'pages.attribute_icons.edit';

        return $this->renderOutput(compact('attributeIcon'));
    }

    /**
     * Update the specified AttributeIcon in storage.
     */
    public function update($id, UpdateAttributeIconRequest $request)
    {
        $attributeIcon = $this->attributeIconRepository->find($id);

        if (empty($attributeIcon)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('attributeIcons.index'));
        }

        $attributeIcon = $this->attributeIconRepository->update($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        return redirect(route('attributeIcons.index'));
    }

    /**
     * Remove the specified AttributeIcon from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $attributeIcon = $this->attributeIconRepository->find($id);

        if (empty($attributeIcon)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('attributeIcons.index'));
        }

        $this->attributeIconRepository->delete($id);

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('attributeIcons.index'));
    }
}
