<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\AppBaseController;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class ApiController extends AppBaseController
{
    /**
     * @var CategoryRepository $categoryRepository;
     * @var String $DEFAULT_LANGUAGE_ID;
     */
    private $categoryRepository;
    private $DEFAULT_LANGUAGE_ID;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
        $this->DEFAULT_LANGUAGE_ID = config('settings.locale.default_language_id');
    }

    public function getCategories(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->categoryRepository->getIdNameMap($this->DEFAULT_LANGUAGE_ID);

            return response()->json(['items' => $data ?? []]);
        } else {
            return abort(404);
        }
    }
}
