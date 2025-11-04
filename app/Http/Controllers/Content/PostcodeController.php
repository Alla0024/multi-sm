<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreatePostcodeRequest;
use App\Http\Requests\UpdatePostcodeRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PostcodeRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\Postcode;
use Flash;

class PostcodeController extends AppBaseController
{
    /** @var PostcodeRepository $postcodeRepository*/
    private $postcodeRepository;

    public function __construct(PostcodeRepository $postcodeRepo)
    {
        parent::__construct();

        $this->postcodeRepository = $postcodeRepo;
    }

    /**
     * Display a listing of the Postcode.
     */
    public function index(Request $request)
    {
        $postcodes = $this->postcodeRepository->filterRows($request->all());

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Postcode::class
        ]);

        $this->template = 'pages.postcodes.index';

        return $this->renderOutput([
            'postcodes' => $postcodes,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new Postcode.
     */
    public function create()
    {
        $this->template = 'pages.postcodes.create';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Postcode::class
        ]);

        return $this->renderOutput([
            'fields' => $fields,
        ]);
    }

    /**
     * Store a newly created Postcode in storage.
     */
    public function store(CreatePostcodeRequest $request)
    {
        $input = $request->all();

        $postcode = $this->postcodeRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('postcodes.index'));
    }

    /**
     * Display the specified Postcode.
     */
    public function show($id)
    {
        $postcode = $this->postcodeRepository->findFull($id);

        if (empty($postcode)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('postcodes.index'));
        }

        $this->template = 'pages.postcodes.show';

        return $this->renderOutput(compact('postcode'));
}

    /**
     * Show the form for editing the specified Postcode.
     */
    public function edit($id)
    {
        $postcode = $this->postcodeRepository->findFull($id);

        if (empty($postcode)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('postcodes.index'));
        }

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Postcode::class
        ]);

        $this->template = 'pages.postcodes.edit';

        return $this->renderOutput(compact('postcode', 'fields'));
    }

    /**
     * Update the specified Postcode in storage.
     */
    public function update($id, UpdatePostcodeRequest $request)
    {
        $postcode = $this->postcodeRepository->find($id);

        if (empty($postcode)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('postcodes.index'));
        }

        $postcode = $this->postcodeRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        if ($request->ajax()) {
            return redirect(route('postcodes.edit', $id));
        }

        return redirect(route('postcodes.index'));
    }

    /**
     * Remove the specified Postcode from storage.
     *
     * @throws \Exception
     */
    public function destroy($ids)
    {
        $this->postcodeRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('postcodes.index'));
    }

    public function copy(Request $request)
    {
        $ids = $request->input('postcode_ids');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->postcodeRepository->copy($ids);

            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('postcodes.index');
        }

        Flash::error(__('common.flash_error'));

        return redirect()->route('postcodes.index');
    }
}
