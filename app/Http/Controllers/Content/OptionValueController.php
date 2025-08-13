<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateOptionValueRequest;
use App\Http\Requests\UpdateOptionValueRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\OptionValueRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\OptionValue;
use Flash;

class OptionValueController extends AppBaseController
{
    /** @var OptionValueRepository $optionValueRepository*/
    private OptionValueRepository $optionValueRepository;
    private int $defaultLanguageId;

    public function __construct(OptionValueRepository $optionValueRepo)
    {
        parent::__construct();

        $this->optionValueRepository = $optionValueRepo;
        $this->defaultLanguageId = config('settings.locale.default_language_id');
    }

    /**
     * Display a listing of the OptionValue.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $optionValues = $this->optionValueRepository->filterIndexPage($perPage, request()->all(), $this->defaultLanguageId);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            OptionValue::class
        ], [
            'name',
            'image',
            'sort_order',
            'level',
        ]);

        $this->template = 'pages.option_values.index';

        return $this->renderOutput([
            'optionValues' => $optionValues,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new OptionValue.
     */
    public function create()
    {
        $this->template = 'pages.option_values.create';

        return $this->renderOutput();
    }

    /**
     * Store a newly created OptionValue in storage.
     */
    public function store(CreateOptionValueRequest $request)
    {
        $input = $request->all();

        $optionValue = $this->optionValueRepository->create($input);

        Flash::success('Option Value saved successfully.');

        return redirect(route('optionValues.index'));
    }

    /**
     * Display the specified OptionValue.
     */
    public function show($id)
    {
        $optionValue = $this->optionValueRepository->find($id);

        if (empty($optionValue)) {
            Flash::error('Option Value not found');

            return redirect(route('optionValues.index'));
        }

        $this->template = 'pages.option_values.show';

        return $this->renderOutput(compact('optionValue'));
}

    /**
     * Show the form for editing the specified OptionValue.
     */
    public function edit($id)
    {
        $optionValue = $this->optionValueRepository->find($id);

        if (empty($optionValue)) {
            Flash::error('Option Value not found');

            return redirect(route('optionValues.index'));
        }

        $this->template = 'pages.option_values.edit';

        return $this->renderOutput(compact('optionValue'));
    }

    /**
     * Update the specified OptionValue in storage.
     */
    public function update($id, UpdateOptionValueRequest $request)
    {
        $optionValue = $this->optionValueRepository->find($id);

        if (empty($optionValue)) {
            Flash::error('Option Value not found');

            return redirect(route('optionValues.index'));
        }

        $optionValue = $this->optionValueRepository->update($request->all(), $id);

        Flash::success('Option Value updated successfully.');

        return redirect(route('optionValues.index'));
    }

    /**
     * Remove the specified OptionValue from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $optionValue = $this->optionValueRepository->find($id);

        if (empty($optionValue)) {
            Flash::error('Option Value not found');

            return redirect(route('optionValues.index'));
        }

        $this->optionValueRepository->delete($id);

        Flash::success('Option Value deleted successfully.');

        return redirect(route('optionValues.index'));
    }
}
