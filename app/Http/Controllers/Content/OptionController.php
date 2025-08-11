<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateOptionRequest;
use App\Http\Requests\UpdateOptionRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\OptionRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\Option;
use Flash;

class OptionController extends AppBaseController
{
    /**
     * @var OptionRepository $optionRepository
     */
    private OptionRepository $optionRepository;

    public function __construct(OptionRepository $optionRepo)
    {
        parent::__construct();

        $this->optionRepository = $optionRepo;
    }

    /**
     * Display a listing of the Option.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $options = $this->optionRepository->paginate($perPage);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Option::class
        ]);

        $this->template = 'pages.options.index';

        return $this->renderOutput([
            'options' => $options,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new Option.
     */
    public function create()
    {
        $this->template = 'pages.options.create';

        return $this->renderOutput();
    }

    /**
     * Store a newly created Option in storage.
     */
    public function store(CreateOptionRequest $request)
    {
        $input = $request->all();

        $option = $this->optionRepository->create($input);

        Flash::success('Option saved successfully.');

        return redirect(route('options.index'));
    }

    /**
     * Display the specified Option.
     */
    public function show($id)
    {
        $option = $this->optionRepository->find($id);

        if (empty($option)) {
            Flash::error('Option not found');

            return redirect(route('options.index'));
        }
//        option_values_count
        $this->template = 'pages.options.show';

        return $this->renderOutput(compact('option'));
    }

    /**
     * Show the form for editing the specified Option.
     */
    public function edit($id)
    {
        $option = $this->optionRepository->find($id);

        if (empty($option)) {
            Flash::error('Option not found');

            return redirect(route('options.index'));
        }

        $this->template = 'pages.options.edit';

        return $this->renderOutput(compact('option'));
    }

    /**
     * Update the specified Option in storage.
     */
    public function update($id, UpdateOptionRequest $request)
    {
        $option = $this->optionRepository->find($id);

        if (empty($option)) {
            Flash::error('Option not found');

            return redirect(route('options.index'));
        }

        $option = $this->optionRepository->update($request->all(), $id);

        Flash::success('Option updated successfully.');

        return redirect(route('options.index'));
    }

    /**
     * Remove the specified Option from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $option = $this->optionRepository->find($id);

        if (empty($option)) {
            Flash::error('Option not found');

            return redirect(route('options.index'));
        }

        $this->optionRepository->delete($id);

        Flash::success('Option deleted successfully.');

        return redirect(route('options.index'));
    }
}
