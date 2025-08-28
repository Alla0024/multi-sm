<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateAttributeWordRequest;
use App\Http\Requests\UpdateAttributeWordRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\AttributeWordRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\AttributeWord;
use Flash;

class AttributeWordController extends AppBaseController
{
    /** @var AttributeWordRepository $attributeWordRepository*/
    private $attributeWordRepository;

    public function __construct(AttributeWordRepository $attributeWordRepo)
    {
        parent::__construct();

        $this->attributeWordRepository = $attributeWordRepo;
    }

    /**
     * Display a listing of the AttributeWord.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $attributeWords = $this->attributeWordRepository->paginate($perPage);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            AttributeWord::class
        ]);

        $this->template = 'pages.attribute_words.index';

        return $this->renderOutput([
            'attributeWords' => $attributeWords,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new AttributeWord.
     */
    public function create()
    {
        $this->template = 'pages.attribute_words.create';

        return $this->renderOutput();
    }

    /**
     * Store a newly created AttributeWord in storage.
     */
    public function store(CreateAttributeWordRequest $request)
    {
        $input = $request->all();

        $attributeWord = $this->attributeWordRepository->create($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('attributeWords.index'));
    }

    /**
     * Display the specified AttributeWord.
     */
    public function show($id)
    {
        $attributeWord = $this->attributeWordRepository->find($id);

        if (empty($attributeWord)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('attributeWords.index'));
        }

        $this->template = 'pages.attribute_words.show';

        return $this->renderOutput(compact('attributeWord'));
}

    /**
     * Show the form for editing the specified AttributeWord.
     */
    public function edit($id)
    {
        $attributeWord = $this->attributeWordRepository->find($id);

        if (empty($attributeWord)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('attributeWords.index'));
        }

        $this->template = 'pages.attribute_words.edit';

        return $this->renderOutput(compact('attributeWord'));
    }

    /**
     * Update the specified AttributeWord in storage.
     */
    public function update($id, UpdateAttributeWordRequest $request)
    {
        $attributeWord = $this->attributeWordRepository->find($id);

        if (empty($attributeWord)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('attributeWords.index'));
        }

        $attributeWord = $this->attributeWordRepository->update($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        return redirect(route('attributeWords.index'));
    }

    /**
     * Remove the specified AttributeWord from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $attributeWord = $this->attributeWordRepository->find($id);

        if (empty($attributeWord)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('attributeWords.index'));
        }

        $this->attributeWordRepository->delete($id);

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('attributeWords.index'));
    }
}
