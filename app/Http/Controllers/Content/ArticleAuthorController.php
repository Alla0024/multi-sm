<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateArticleAuthorRequest;
use App\Http\Requests\UpdateArticleAuthorRequest;
use App\Http\Controllers\AppBaseController;
use App\Models\ArticleAuthorDescription;
use App\Models\FirstPathQuery;
use App\Repositories\ArticleAuthorRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\ArticleAuthor;
use Flash;

class ArticleAuthorController extends AppBaseController
{
    /**
     * @var ArticleAuthorRepository $articleAuthorRepository
     * @var int $defaultLanguageId
     */
    private ArticleAuthorRepository $articleAuthorRepository;

    public function __construct(ArticleAuthorRepository $articleAuthorRepo)
    {
        parent::__construct();

        $this->articleAuthorRepository = $articleAuthorRepo;
    }

    /**
     * Display a listing of the ArticleAuthor.
     */
    public function index(Request $request)
    {
        $articleAuthors = $this->articleAuthorRepository->filterIndexPage($request);

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            ArticleAuthorDescription::class,
            ArticleAuthor::class
        ]);

        $this->template = 'pages.article_authors.index';

        return $this->renderOutput([
            'articleAuthors' => $articleAuthors,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new ArticleAuthor.
     */
    public function create()
    {
        $this->template = 'pages.article_authors.create';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            ArticleAuthor::class,
            ArticleAuthorDescription::class,
            FirstPathQuery::class
        ]);
        return $this->renderOutput([
            'fields' => $fields,
            'inTabs' => array_unique(array_column($fields, 'inTab')),
        ]);
    }

    /**
     * Store a newly created ArticleAuthor in storage.
     */
    public function store(CreateArticleAuthorRequest $request)
    {
        $input = $request->all();

        $articleAuthor = $this->articleAuthorRepository->create($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('articleAuthors.index'));
    }

    /**
     * Display the specified ArticleAuthor.
     */
    public function show($id)
    {
        $articleAuthor = $this->articleAuthorRepository->find($id);

        if (empty($articleAuthor)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('articleAuthors.index'));
        }

        $this->template = 'pages.article_authors.show';

        return $this->renderOutput(compact('articleAuthor'));
    }

    /**
     * Show the form for editing the specified ArticleAuthor.
     */
    public function edit($id)
    {
        $articleAuthor = $this->articleAuthorRepository->find($id);

        if (empty($articleAuthor)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('articleAuthors.index'));
        }

        $this->template = 'pages.article_authors.edit';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            ArticleAuthor::class,
            ArticleAuthorDescription::class,
            FirstPathQuery::class
        ]);
        return $this->renderOutput([
            'articleAuthor' => $articleAuthor,
            'fields' => $fields,
            'inTabs' => array_unique(array_column($fields, 'inTab')),
        ]);
    }

    /**
     * Update the specified ArticleAuthor in storage.
     */
    public function update($id, UpdateArticleAuthorRequest $request)
    {
        $articleAuthor = $this->articleAuthorRepository->find($id);

        if (empty($articleAuthor)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('articleAuthors.index'));
        }

        $this->articleAuthorRepository->update($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        return redirect(route('articleAuthors.index'));
    }

    /**
     * Remove the specified ArticleAuthor from storage.
     *
     * @throws \Exception
     */
    public function destroy($ids)
    {
        $this->articleAuthorRepository->multiDelete(explode(',', $ids));

        Flash::success(__('common.flash_deleted_successfully'));

        return redirect(route('articleAuthors.index'));
    }

    public function copy(Request $request)
    {
        $ids = $request->input('articleAuthor_id');

        if ($request->ajax() && filled($ids)) {
            $ids = is_array($ids) ? $ids : explode(',', $ids);

            $this->articleAuthorRepository->copy($ids);

            Flash::success(__('common.flash_copied_successfully'));

            return redirect()->route('articleAuthors.index');
        }

        Flash::error(__('common.flash_error'));

        return redirect()->route('articleAuthors.index');
    }
}
