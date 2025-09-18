<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateAttributeIconRequest;
use App\Http\Requests\UpdateAttributeIconRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\Language;
use App\Repositories\AttributeIconRepository;
use App\Helpers\ModelSchemaHelper;
use App\Repositories\AttributeRepository;
use Illuminate\Http\Request;
use App\Models\AttributeIcon;
use Flash;

class AttributeIconController extends AppBaseController
{
    /**
     * @var AttributeIconRepository $attributeIconRepository
     * @var AttributeRepository $attributeRepository
     */
    private $attributeIconRepository;
    private $attributeRepository;

    public function __construct(AttributeIconRepository $attributeIconRepo, AttributeRepository $attributeRepository)
    {
        parent::__construct();

        $this->attributeIconRepository = $attributeIconRepo;
        $this->attributeRepository = $attributeRepository;
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
        $attributes = $this->attributeRepository->getDropdownItems()->pluck('text', 'id')->toArray();
        $values = [ '1' => __('attribute_icons.value_show'), "0" => __('attribute_icons.value_hide') ];

        $this->template = 'pages.attribute_icons.create';

        return $this->renderOutput(compact('values', 'attributes'));
    }

    /**
     * Store a newly created AttributeIcon in storage.
     */
    public function store(CreateAttributeIconRequest $request)
    {
        $input = $request->all();

        $attributeIcon = $this->attributeIconRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('attributeIcons.index'));
    }

    /**
     * Display the specified AttributeIcon.
     */
    public function show($id)
    {
        $attributeIcon = $this->attributeIconRepository->find($id);
        $languages = Language::getLanguages();

        if (empty($attributeIcon)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('attributeIcons.index'));
        }

        $this->template = 'pages.attribute_icons.show';

        return $this->renderOutput(compact('attributeIcon', 'languages'));
}

    /**
     * Show the form for editing the specified AttributeIcon.
     */
    public function edit($id)
    {
        $attributeIcon = $this->attributeIconRepository->findFull($id);
        $attributes = $this->attributeRepository->getDropdownItems()->pluck('text', 'id')->toArray();
        $languages = Language::getLanguages();
        $values = [ '1' => __('attribute_icons.value_show'), "0" => __('attribute_icons.value_hide') ];

        if (empty($attributeIcon)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('attributeIcons.index'));
        }

        $this->template = 'pages.attribute_icons.edit';

        return $this->renderOutput(compact('attributeIcon', 'languages', 'values', 'attributes'));
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

        $attributeIcon = $this->attributeIconRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        return redirect(route('attributeIcons.index'));
    }

    /**
     * Remove the specified AttributeIcon from storage.
     *
     * @throws \Exception
     */
    public function destroy($ids)
    {
        $this->attributeIconRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('attributeIcons.index'));
    }

    public function copy(Request $request)
    {
        $ids = $request->input('news_id');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->attributeIconRepository->copy($ids);

            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('attributeIcons.index');
        }

        Flash::error(__('common.flash_error'));

        return redirect()->route('attributeIcons.index');
    }
}
