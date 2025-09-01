<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\AttributeRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\Attribute;
use Flash;

class AttributeController extends AppBaseController
{
    /** @var AttributeRepository $attributeRepository*/
    private $attributeRepository;

    public function __construct(AttributeRepository $attributeRepo)
    {
        parent::__construct();

        $this->attributeRepository = $attributeRepo;
    }

    /**
     * Display a listing of the Attribute.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $attributes = $this->attributeRepository->paginate($perPage);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Attribute::class
        ]);

        $this->template = 'pages.attributes.index';

        return $this->renderOutput([
            'attributes' => $attributes,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new Attribute.
     */
    public function create()
    {
        $this->template = 'pages.attributes.create';

        return $this->renderOutput();
    }

    /**
     * Store a newly created Attribute in storage.
     */
    public function store(CreateAttributeRequest $request)
    {
        $input = $request->all();

        $attribute = $this->attributeRepository->create($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('attributes.index'));
    }

    /**
     * Display the specified Attribute.
     */
    public function show($id)
    {
        $attribute = $this->attributeRepository->find($id);

        if (empty($attribute)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('attributes.index'));
        }

        $this->template = 'pages.attributes.show';

        return $this->renderOutput(compact('attribute'));
}

    /**
     * Show the form for editing the specified Attribute.
     */
    public function edit($id)
    {
        $attribute = $this->attributeRepository->find($id);

        if (empty($attribute)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('attributes.index'));
        }

        $this->template = 'pages.attributes.edit';

        return $this->renderOutput(compact('attribute'));
    }

    /**
     * Update the specified Attribute in storage.
     */
    public function update($id, UpdateAttributeRequest $request)
    {
        $attribute = $this->attributeRepository->find($id);

        if (empty($attribute)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('attributes.index'));
        }

        $attribute = $this->attributeRepository->update($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        return redirect(route('attributes.index'));
    }

    /**
     * Remove the specified Attribute from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $attribute = $this->attributeRepository->find($id);

        if (empty($attribute)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('attributes.index'));
        }

        $this->attributeRepository->delete($id);

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('attributes.index'));
    }
}
